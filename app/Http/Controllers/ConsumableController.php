<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Consumable;
use App\Models\ConsumableDetail;
use App\Models\Room;
use App\Models\FundingSource;
use App\Models\Transaction; // <-- Tambahin ini kalo belum ada, buat model Transaction
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Ini juga, buat Auth::id()

class ConsumableController extends Controller
{
    // HALAMAN 1: PILIH KATEGORI (Khusus Type Consumable)
    public function indexCategories()
    {
        $categories = Category::where('type', 'consumable')->get();
        return view('pages.consumables.categories', compact('categories'));
    }

    // HALAMAN 2: DAFTAR BARANG (Induk)
    public function indexItems(Category $category)
    {
        // Ambil barang beserta total stok & tgl kadaluarsa tercepat
        $items = Consumable::where('category_id', $category->id)
            ->with(['details']) // Load relasi
            ->get()
            ->map(function ($item) {
                // Hitung Total Stok dari semua batch
                $item->total_stock = $item->details->sum('current_stock');
                // Cari kadaluarsa paling dekat
                $item->nearest_expiry = $item->details->min('expiry_date');
                // Cari tgl pengecekan terakhir
                $item->last_check = $item->details->max('check_date');
                return $item;
            });

        return view('pages.consumables.items', compact('category', 'items'));
    }

    // HALAMAN 3: Form Tambah BHP
    public function create(Category $category)
    {
        return view('pages.consumables.create', compact('category'));
    }

    // SIMPAN INDUK
    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'unit' => 'required', 'category_id' => 'required']);
        $consumable = Consumable::create($request->all());

        // Redirect langsung ke detail (sama seperti inventaris)
        return redirect()->route('consumable.detail', $consumable->id);
    }

    // HALAMAN FORM TAMBAH BATCH (STOK BARU)
    public function createBatch(Consumable $consumable)
    {
        // Ambil data master untuk dropdown
        $rooms = Room::with('unit')->get();
        $fundings = FundingSource::all();

        return view('pages.consumables.create_batch', compact('consumable', 'rooms', 'fundings'));
    }

    // HALAMAN 3: DETAIL BATCH (Anak)
    public function detail(Consumable $consumable)
    {
        // Ambil detail batch urut dari yang terlama (001, 002...)
        $details = $consumable->details()->with(['room', 'fundingSource'])->oldest()->get();

        // Ambil Data Master Ruangan
        $rooms = Room::with('unit')->get();

        // Ambil Data Master Sumber Dana (INI YANG PENTING AGAR DROPDOWN MUNCUL)
        $fundings = FundingSource::all();

        return view('pages.consumables.details', compact('consumable', 'details', 'rooms', 'fundings'));
    }

    // SIMPAN DETAIL BATCH
    public function storeDetail(Request $request)
    {
        $request->validate([
            'consumable_id' => 'required',
            'model_name' => 'required',
            'initial_stock' => 'required|integer|min:1',
            'funding_source_id' => 'required',
            // ... validasi lain
        ]);

        // 1. Ambil Data Pendukung
        $consumable = Consumable::findOrFail($request->consumable_id);
        $sumber = FundingSource::findOrFail($request->funding_source_id);

        // 2. LOGIKA ANTI-BENTROK (COLLISION RESOLUTION)
        // Mulai hitungan dari jumlah yang ada + 1
        $counter = ConsumableDetail::where('consumable_id', $consumable->id)->count() + 1;

        do {
            // Format angka jadi 3 digit (001, 002...)
            $sequence = str_pad($counter, 3, '0', STR_PAD_LEFT);

            // Rakit Kode Calon
            $code = "BHP/" . $sumber->code . "/" . $consumable->category_id . "/" . $sequence;

            // Cek ke database: Apakah kode ini sudah ada?
            $exists = ConsumableDetail::where('batch_code', $code)->exists();

            if ($exists) {
                // Jika sudah ada, naikkan hitungan dan coba lagi (Looping)
                $counter++;
            }

        } while ($exists); // Ulangi terus sampai $exists bernilai false (kode belum terpakai)

        // 3. Simpan dengan Kode yang Dijamin Aman
        $batch = ConsumableDetail::create(array_merge($request->all(), [
            'batch_code' => $code,
            'current_stock' => $request->initial_stock
        ]));

        // 4. Catat Transaksi Masuk
        \App\Models\Transaction::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'consumable_detail_id' => $batch->id,
            'type' => 'masuk',
            'amount' => $request->initial_stock,
            'date' => now(),
            'notes' => 'Stok Awal / Pembelian Baru',
        ]);

        return back()->with('success', 'Batch berhasil ditambahkan. Kode: ' . $code);
    }
}