<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Consumable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // 1. Eager Loading Relasi
        $query = Transaction::with(['detail.consumable', 'user']);

        // 2. Filter Search (Nama Barang atau Kode Batch)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('detail', function($q) use ($search) {
                $q->where('batch_code', 'like', "%$search%")
                  ->orWhereHas('consumable', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%$search%");
                  });
            });
        }

        // 3. Filter Jenis (Masuk/Keluar)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 4. Filter Tanggal Start
        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        // 5. Filter Tanggal End
        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // Urutkan dan Paginate
        $transactions = $query->latest('date')->latest('created_at')->paginate(10);

        return view('pages.transactions.index', compact('transactions'));
    }

    public function create()
    {
        // Ambil Barang yang punya stok > 0
        // Kita kirim data 'consumables' (Induk), bukan batch spesifik
        $consumables = Consumable::whereHas('details', function($q) {
            $q->where('current_stock', '>', 0);
        })->with(['details' => function($q) {
            $q->where('current_stock', '>', 0);
        }])->get();

        return view('pages.transactions.create', compact('consumables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'consumable_id' => 'required|exists:consumables,id',
            'amount' => 'required|integer|min:1',
            'date' => 'required|date',
            'notes' => 'nullable|string', // Notes boleh kosong, jangan required
        ]);

        $item = Consumable::with(['details' => function($q) {
            $q->where('current_stock', '>', 0)->orderBy('created_at', 'asc'); // FIFO: Stok lama keluar dulu
        }])->findOrFail($request->consumable_id);

        // Validasi Stok Total
        $totalAvailable = $item->details->sum('current_stock');
        if ($totalAvailable < $request->amount) {
            return back()->withErrors(['amount' => "Stok tidak cukup! Total tersedia: $totalAvailable, Permintaan: {$request->amount}"]);
        }

        // LOGIKA FIFO
        DB::transaction(function () use ($request, $item) {
            $sisaPermintaan = $request->amount;

            foreach ($item->details as $batch) {
                if ($sisaPermintaan <= 0) break;

                // Ambil stok dari batch ini
                $ambil = min($batch->current_stock, $sisaPermintaan);

                // 1. Kurangi Stok Batch
                $batch->decrement('current_stock', $ambil);

                // 2. Catat Transaksi
                Transaction::create([
                    'user_id' => Auth::id(),
                    'consumable_detail_id' => $batch->id,
                    'type' => 'keluar',
                    'amount' => $ambil,
                    'date' => $request->date,
                    'notes' => $request->notes . " (Batch: {$batch->batch_code})", // Catat batch mana yang diambil
                ]);

                $sisaPermintaan -= $ambil;
            }
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dicatat (Metode FIFO).');
    }
}