<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Consumable;
use App\Models\ConsumableDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // HALAMAN MENU TRANSAKSI
    public function index()
    {
        // Tampilkan riwayat transaksi terbaru
        $transactions = Transaction::with(['detail.consumable', 'user'])
                        ->latest()
                        ->paginate(20);

        return view('pages.transactions.index', compact('transactions'));
    }

    public function create()
    {
        // Ambil Consumable (Induk) yang punya setidaknya satu batch dengan stok > 0
        $consumables = Consumable::whereHas('details', function($q) {
            $q->where('current_stock', '>', 0);
        })->with('details')->get();

        return view('pages.transactions.create', compact('consumables'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'consumable_id' => 'required|exists:consumables,id', // Validasi ke Induk, bukan batch
            'amount' => 'required|integer|min:1',
            'date' => 'required|date',
            'notes' => 'required|string',
        ]);

        // 1. Ambil Barang Induk beserta Batch-nya
        // PENTING: Urutkan batch berdasarkan tanggal kedatangan (oldest) atau expired (asc)
        // Disini kita pakai Logika FIFO murni (created_at terlama keluar duluan)
        $item = Consumable::with(['details' => function($q) {
            $q->where('current_stock', '>', 0)->orderBy('created_at', 'asc');
        }])->findOrFail($request->consumable_id);

        // 2. Validasi Stok Total
        $totalAvailable = $item->details->sum('current_stock');
        if ($totalAvailable < $request->amount) {
            return back()->withErrors(['amount' => "Stok tidak cukup! Total tersedia: $totalAvailable, Permintaan: {$request->amount}"]);
        }

        // 3. ALGORITMA FIFO (The Core Logic)
        DB::transaction(function () use ($request, $item) {
            
            $sisaPermintaan = $request->amount; // Misal butuh 10

            foreach ($item->details as $batch) {
                // Jika permintaan sudah terpenuhi, stop looping
                if ($sisaPermintaan <= 0) break;

                // Cek berapa yang bisa diambil dari batch ini
                // Ambil yang lebih kecil: Sisa Stok Batch atau Sisa Permintaan
                $ambil = min($batch->current_stock, $sisaPermintaan);

                // A. Kurangi Stok Batch
                $batch->decrement('current_stock', $ambil);

                // B. Catat Transaksi per Batch (Agar Audit Trail jelas)
                Transaction::create([
                    'user_id' => Auth::id(),
                    'consumable_detail_id' => $batch->id, // ID Batch Spesifik
                    'type' => 'keluar',
                    'amount' => $ambil,
                    'date' => $request->date,
                    'notes' => $request->notes . " (Auto FIFO)",
                ]);

                // Kurangi sisa permintaan
                $sisaPermintaan -= $ambil;
            }
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil. Stok dikurangi menggunakan metode FIFO.');
    }
}