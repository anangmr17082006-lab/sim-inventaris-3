<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Inventory;
use App\Models\AssetDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    // 1. DAFTAR PEMINJAMAN (History & Sedang Dipinjam)
    public function index()
    {
        // Tampilkan yang statusnya 'dipinjam' di atas
        $loans = Loan::with('asset.inventory')
                 ->orderByRaw("FIELD(status, 'dipinjam', 'telat', 'kembali')")
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
        
        $inventories = Inventory::whereHas('details', function($q) {
            $q->where('status', 'tersedia')->where('condition', 'baik');
        })->with(['details' => function($q) {
            $q->where('status', 'tersedia')->where('condition', 'baik');
        }])->get();

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

        // 1. Cek Status Ketersediaan
        if ($asset->status != 'tersedia') {
            return back()->withErrors(['msg' => 'Gagal! Barang ini sedang dipinjam orang lain.']);
        }

        // 2. Cek Kondisi Fisik (TAMBAHAN PENTING)
        if ($asset->condition == 'rusak_berat') {
            return back()->withErrors(['msg' => 'Gagal! Barang rusak berat tidak boleh dipinjam.']);
        }

        DB::transaction(function () use ($request, $asset) {
            // 1. Simpan Peminjaman
            Loan::create(array_merge($request->all(), ['status' => 'dipinjam']));

            // 2. Update Status Aset
            $asset->update(['status' => 'dipinjam']);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat. Status barang berubah.');
    }
    
    // ACTION PENGEMBALIAN BARANG
    public function returnItem(Request $request, Loan $loan)
    {
        // Update Loan jadi 'kembali'
        $loan->update([
            'status' => 'kembali',
            'return_date_actual' => now(),
            'notes' => $loan->notes . ' | Dikembalikan: ' . $request->notes // Catatan kondisi saat kembali
        ]);
        
        // Update Aset jadi 'tersedia' lagi
        $loan->asset->update(['status' => 'tersedia']);
        
        return back()->with('success', 'Barang berhasil dikembalikan.');
    }
}