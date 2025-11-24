<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Inventory;
use App\Models\AssetDetail;
use App\Enums\AssetStatus;
use App\Enums\AssetCondition;
use App\Enums\LoanStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    // 1. DAFTAR PEMINJAMAN (History & Sedang Dipinjam)
    public function index()
    {
        // Tampilkan yang statusnya 'dipinjam' di atas
        $loans = Loan::with('asset.inventory')
            ->orderByRaw("CASE 
                    WHEN status = '" . LoanStatus::DIPINJAM->value . "' THEN 1 
                    WHEN status = '" . LoanStatus::TELAT->value . "' THEN 2 
                    WHEN status = '" . LoanStatus::KEMBALI->value . "' THEN 3 
                    ELSE 4 
                 END")
            ->latest()
            ->paginate(10);

        return view('pages.loans.index', compact('loans'));
    }

    // 2. FORM PINJAM BARANG
    public function create()
    {
        // REVISI LOGIKA:
        // Gunakan whereHas untuk memfilter HANYA Inventaris yang punya setidaknya 1 unit tersedia.
        // Kalau unitnya habis/dipinjam semua, nama barangnya tidak usah muncul di dropdown.

        $inventories = Inventory::whereHas('details', function ($q) {
            $q->where('status', AssetStatus::TERSEDIA->value)
                ->where('condition', AssetCondition::BAIK->value);
        })->with([
                    'details' => function ($q) {
                        $q->where('status', AssetStatus::TERSEDIA->value)
                            ->where('condition', AssetCondition::BAIK->value);
                    }
                ])->get();

        return view('pages.loans.create', compact('inventories'));
    }

    // 3. PROSES PINJAM (Action)
    public function store(Request $request)
    {
        $request->validate([
            'asset_detail_id' => 'required',
            'borrower_name' => 'required',
            'borrower_id' => 'required',
            'loan_date' => 'required|date',
            'return_date_plan' => 'required|date|after_or_equal:loan_date',
        ]);

        $asset = AssetDetail::findOrFail($request->asset_detail_id);

        // Gunakan method isBorrowable() dari Model
        if (!$asset->isBorrowable()) {
            return back()->withErrors(['msg' => 'Barang tidak memenuhi syarat untuk dipinjam (Rusak Berat / Sedang Dipinjam).']);
        }

        DB::transaction(function () use ($request, $asset) {
            // 1. Simpan Peminjaman
            Loan::create(array_merge($request->all(), ['status' => LoanStatus::DIPINJAM->value]));

            // 2. Update Status Aset
            $asset->update(['status' => AssetStatus::DIPINJAM->value]);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat. Status barang berubah.');
    }

    // ACTION PENGEMBALIAN BARANG
    public function returnItem(Request $request, Loan $loan)
    {
        // Update Loan jadi 'kembali'
        $loan->update([
            'status' => LoanStatus::KEMBALI->value,
            'return_date_actual' => now(),
            'notes' => $loan->notes . ' | Dikembalikan: ' . $request->notes // Catatan kondisi saat kembali
        ]);

        // Update Aset jadi 'tersedia' lagi
        $loan->asset->update(['status' => AssetStatus::TERSEDIA->value]);

        return back()->with('success', 'Barang berhasil dikembalikan.');
    }
}