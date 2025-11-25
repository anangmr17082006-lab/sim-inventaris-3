<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Enums\AssetCondition; // Pastikan namespace Enum ini benar

class InventoryController extends Controller
{
    // 1. HALAMAN KATEGORI (Dashboard Aset)
    public function indexCategories()
    {
        // Saya tambahkan withCount agar Kartu Kategori di View menampilkan angka statistik
        // Asumsi: Relasi 'inventories' ada di model Category
        $categories = Category::withCount(['inventories as total_types', 'assets as total_units'])
                      ->get();

        return view('pages.inventories.categories', compact('categories'));
    }

    // 2. DAFTAR BARANG (Dengan Filter & Pagination)
    public function indexItems(Request $request, Category $category)
    {
        $search = $request->input('search');

        // Query Utama
        $query = Inventory::where('category_id', $category->id)
            ->withCount([
                'details as total_unit', 
                // Hitung kondisi aset secara efisien
                'details as baik' => function ($q) {
                    $q->where('condition', 'baik'); // Sesuaikan string jika tidak pakai Enum
                },
                'details as rusak_ringan' => function ($q) {
                    $q->where('condition', 'rusak-ringan');
                },
                'details as rusak_berat' => function ($q) {
                    $q->where('condition', 'rusak-berat');
                }
            ]);

        // LOGIKA SEARCH (Ini yang kamu lupakan!)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Pagination wajib ada
        $items = $query->latest()->paginate(10);

        return view('pages.inventories.items', compact('category', 'items'));
    }

    // 3. FORM TAMBAH BARANG
    public function create(Category $category)
    {
        return view('pages.inventories.create', compact('category'));
    }

    // 4. SIMPAN BARANG
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'brand' => 'nullable|string', // Tambahan field umum
        ]);

        $inventory = Inventory::create($request->all());

        // UX Bagus dari kamu: Langsung redirect ke input unit fisik
        return redirect()->route('asset.index', $inventory->id)
            ->with('success', 'Data induk berhasil dibuat. Silakan tambahkan unit fisik.');
    }

    // 5. EDIT FORM
    public function edit(Inventory $inventaris)
    {
        // Pakai Route Model Binding yang konsisten
        $categories = Category::all();
        return view('pages.inventories.edit', compact('inventaris', 'categories'));
    }

    // 6. UPDATE DATA
    public function update(Request $request, Inventory $inventaris)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'brand' => 'nullable|string',
        ]);

        $inventaris->update($request->all());

        return redirect()->route('inventaris.items', $inventaris->category_id)
            ->with('success', 'Data aset berhasil diperbarui.');
    }

    // 7. DESTROY (Wajib ada untuk kebersihan data)
    public function destroy(Inventory $inventaris)
    {
        // Cek relasi anak sebelum hapus
        if ($inventaris->details()->exists()) {
            return back()->withErrors(['Gagal hapus! Barang ini masih memiliki unit fisik terdaftar. Hapus unitnya dulu.']);
        }

        $categoryId = $inventaris->category_id;
        $inventaris->delete();

        return redirect()->route('inventaris.items', $categoryId)
            ->with('success', 'Data induk barang dihapus.');
    }
}