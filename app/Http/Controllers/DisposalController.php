<?php

namespace App\Http\Controllers;

use App\Enums\DisposalStatus;
use App\Enums\DisposalType;
use App\Models\AssetDetail;
use App\Models\Disposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DisposalController extends Controller
{
    /**
     * Display a listing of disposal requests
     */
    public function index()
    {
        $user = Auth::user();

        // Admin sees all disposals, staff sees only their own
        // Use withTrashed() to load soft-deleted assets
        $disposals = $user->role === 'admin'
            ? Disposal::with([
                'assetDetail' => function ($query) {
                    $query->withTrashed();
                },
                'assetDetail.inventory',
                'requester',
                'reviewer'
            ])->latest()->paginate(20)
            : Disposal::with([
                'assetDetail' => function ($query) {
                    $query->withTrashed();
                },
                'assetDetail.inventory',
                'reviewer'
            ])->where('requested_by', $user->id)->latest()->paginate(20);

        // Count pending disposals for admin
        $pendingCount = $user->role === 'admin'
            ? Disposal::pending()->count()
            : 0;

        return view('pages.disposals.index', compact('disposals', 'pendingCount'));
    }

    /**
     * Show the form for creating a new disposal request
     */
    public function create(AssetDetail $assetDetail)
    {
        // Check if asset can be disposed
        if (!$assetDetail->isDisposable()) {
            return redirect()
                ->route('assets.index')
                ->with('error', 'Aset tidak dapat di-disposal. Pastikan aset tidak sedang dipinjam atau memiliki mutasi pending.');
        }

        // Check if there's already a pending disposal request for this asset
        $existingDisposal = Disposal::where('asset_detail_id', $assetDetail->id)
            ->pending()
            ->first();

        if ($existingDisposal) {
            return redirect()
                ->route('disposals.show', $existingDisposal)
                ->with('info', 'Sudah ada pengajuan disposal pending untuk aset ini.');
        }

        $disposalTypes = DisposalType::cases();

        return view('pages.disposals.create', compact('assetDetail', 'disposalTypes'));
    }

    /**
     * Store a newly created disposal request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_detail_id' => 'required|exists:asset_details,id',
            'disposal_type' => 'required|in:' . implode(',', array_column(DisposalType::cases(), 'value')),
            'reason' => 'required|string|min:20',
            'evidence_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string',
        ], [
            'asset_detail_id.required' => 'Aset harus dipilih.',
            'asset_detail_id.exists' => 'Aset tidak ditemukan.',
            'disposal_type.required' => 'Tipe disposal harus dipilih.',
            'disposal_type.in' => 'Tipe disposal tidak valid.',
            'reason.required' => 'Alasan disposal harus diisi.',
            'reason.min' => 'Alasan disposal minimal 20 karakter.',
            'evidence_photo.required' => 'Foto bukti harus diupload.',
            'evidence_photo.image' => 'File harus berupa gambar.',
            'evidence_photo.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'evidence_photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $asset = AssetDetail::findOrFail($validated['asset_detail_id']);

        // Double check if asset can be disposed
        if (!$asset->isDisposable()) {
            return redirect()
                ->route('assets.index')
                ->with('error', 'Aset tidak dapat di-disposal saat ini.');
        }

        // Handle photo upload
        $photoPath = $request->file('evidence_photo')->store('disposal_evidence', 'public');

        // Create disposal request
        $disposal = Disposal::create([
            'asset_detail_id' => $validated['asset_detail_id'],
            'disposal_type' => $validated['disposal_type'],
            'status' => DisposalStatus::PENDING->value,
            'reason' => $validated['reason'],
            'evidence_photo' => $photoPath,
            'requested_by' => Auth::id(),
            'notes' => $validated['notes'],
        ]);

        return redirect()
            ->route('disposals.show', $disposal)
            ->with('success', 'Pengajuan disposal berhasil dibuat. Menunggu persetujuan admin.');
    }

    /**
     * Display the specified disposal request
     */
    public function show(Disposal $disposal)
    {
        // Load relationships including soft-deleted assets
        $disposal->load([
            'assetDetail' => function ($query) {
                $query->withTrashed();
            },
            'assetDetail.inventory.category',
            'assetDetail.room.unit',
            'requester',
            'reviewer'
        ]);

        // Check authorization
        $user = Auth::user();
        if ($user->role !== 'admin' && $disposal->requested_by !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return view('pages.disposals.show', compact('disposal'));
    }

    /**
     * Show the review page for admin
     */
    public function review(Disposal $disposal)
    {
        // Only admin can review
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Only pending disposals can be reviewed
        if ($disposal->status !== DisposalStatus::PENDING) {
            return redirect()
                ->route('disposals.show', $disposal)
                ->with('info', 'Disposal ini sudah di-review.');
        }

        $disposal->load(['assetDetail.inventory.category', 'assetDetail.room.unit', 'assetDetail.fundingSource', 'requester']);

        return view('pages.disposals.review', compact('disposal'));
    }

    /**
     * Approve disposal request
     */
    public function approve(Request $request, Disposal $disposal)
    {
        // Only admin can approve
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        if (!$disposal->canBeApproved()) {
            return redirect()
                ->route('disposals.review', $disposal)
                ->with('error', 'Disposal tidak dapat disetujui. Pastikan aset tidak sedang dipinjam atau memiliki mutasi pending.');
        }

        $success = $disposal->approve(Auth::user(), $validated['notes'] ?? null);

        if ($success) {
            return redirect()
                ->route('disposals.show', $disposal)
                ->with('success', 'Disposal berhasil disetujui. Aset telah dihapus dari sistem.');
        }

        return redirect()
            ->route('disposals.review', $disposal)
            ->with('error', 'Gagal menyetujui disposal.');
    }

    /**
     * Reject disposal request
     */
    public function reject(Request $request, Disposal $disposal)
    {
        // Only admin can reject
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ], [
            'rejection_reason.required' => 'Alasan penolakan harus diisi.',
            'rejection_reason.min' => 'Alasan penolakan minimal 10 karakter.',
        ]);

        $success = $disposal->reject(Auth::user(), $validated['rejection_reason']);

        if ($success) {
            return redirect()
                ->route('disposals.show', $disposal)
                ->with('success', 'Disposal ditolak.');
        }

        return redirect()
            ->route('disposals.review', $disposal)
            ->with('error', 'Gagal menolak disposal.');
    }

    /**
     * Export disposal report to PDF
     */
    public function exportPdf(Request $request)
    {
        // Only admin can export
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'disposal_type' => 'nullable|in:' . implode(',', array_column(DisposalType::cases(), 'value')),
        ]);

        $query = Disposal::approved()
            ->with([
                'assetDetail' => function ($q) {
                    $q->withTrashed();
                },
                'assetDetail.inventory',
                'requester',
                'reviewer'
            ]);

        if ($request->filled('start_date')) {
            $query->whereDate('approved_at', '>=', $validated['start_date']);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('approved_at', '<=', $validated['end_date']);
        }

        if ($request->filled('disposal_type')) {
            $query->where('disposal_type', $validated['disposal_type']);
        }

        $disposals = $query->orderBy('approved_at', 'desc')->get();
        $totalBookValue = $disposals->sum('book_value');

        // Generate PDF using DomPDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.disposals.report', [
            'disposals' => $disposals,
            'totalBookValue' => $totalBookValue,
        ]);

        // Set paper size and orientation
        $pdf->setPaper('a4', 'landscape');

        // Generate filename with timestamp
        $filename = 'Laporan_Disposal_' . now()->format('Y-m-d_His') . '.pdf';

        // Download PDF
        return $pdf->download($filename);
    }
}
