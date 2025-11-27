<?php

namespace App\Http\Controllers;

use App\Models\Mutation;
use App\Models\AssetDetail;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Enums\MutationStatus;

class MutationController extends Controller
{
    /**
     * Display a listing of mutations with filters
     */
    public function index(Request $request)
    {
        $query = Mutation::with(['asset.inventory', 'fromRoom', 'toRoom', 'requestedBy', 'approvedBy']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('mutation_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('mutation_date', '<=', $request->date_to);
        }

        // Search by asset code or room name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('asset', function ($subQ) use ($search) {
                    $subQ->where('unit_code', 'like', "%$search%")
                        ->orWhere('model_name', 'like', "%$search%");
                })
                    ->orWhereHas('fromRoom', function ($subQ) use ($search) {
                        $subQ->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('toRoom', function ($subQ) use ($search) {
                        $subQ->where('name', 'like', "%$search%");
                    });
            });
        }

        $mutations = $query->latest()->paginate(10);

        return view('pages.mutations.index', compact('mutations'));
    }

    /**
     * Show the form for creating a new mutation
     */
    public function create()
    {
        // Get all assets that are available (tersedia)
        $assets = AssetDetail::with(['inventory', 'room'])
            ->where('status', 'tersedia')
            ->orderBy('unit_code')
            ->get();

        // Get all rooms
        $rooms = Room::with('unit')->orderBy('name')->get();

        return view('pages.mutations.create', compact('assets', 'rooms'));
    }

    /**
     * Store a newly created mutation in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:asset_details,id',
            'to_room_id' => 'required|exists:rooms,id',
            'mutation_date' => 'required|date',
            'reason' => 'required|string|min:10',
            'asset_condition' => 'required|in:baik,rusak_ringan,rusak_berat',
            'notes' => 'nullable|string',
        ]);

        // Get asset to validate room change
        $asset = AssetDetail::findOrFail($validated['asset_id']);

        // Validate that to_room_id is different from current room
        if ($asset->room_id == $validated['to_room_id']) {
            return back()->withErrors([
                'to_room_id' => 'Ruangan tujuan harus berbeda dengan ruangan saat ini.'
            ])->withInput();
        }

        // Create mutation with PENDING status
        Mutation::create([
            'asset_id' => $validated['asset_id'],
            'from_room_id' => $asset->room_id,
            'to_room_id' => $validated['to_room_id'],
            'mutation_date' => $validated['mutation_date'],
            'reason' => $validated['reason'],
            'asset_condition' => $validated['asset_condition'],
            'notes' => $validated['notes'] ?? null,
            'status' => MutationStatus::PENDING,
            'requested_by' => auth()->id(),
        ]);

        return redirect()->route('mutasi.index')
            ->with('success', 'Pengajuan mutasi berhasil dibuat. Menunggu approval.');
    }

    /**
     * Display the specified mutation
     */
    public function show(Mutation $mutation)
    {
        $mutation->load(['asset.inventory', 'fromRoom.unit', 'toRoom.unit', 'requestedBy', 'approvedBy']);

        return view('pages.mutations.show', compact('mutation'));
    }

    /**
     * Approve the specified mutation
     */
    public function approve(Mutation $mutation)
    {
        try {
            $mutation->approve(auth()->id());

            return redirect()->route('mutasi.show', $mutation)
                ->with('success', 'Mutasi berhasil di-approve. Ruangan aset telah diupdate.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Reject the specified mutation
     */
    public function reject(Mutation $mutation)
    {
        try {
            $mutation->reject(auth()->id());

            return redirect()->route('mutasi.show', $mutation)
                ->with('success', 'Mutasi berhasil di-reject.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
