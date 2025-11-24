<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // Halaman 1: Tampilkan 9 Kategori
    public function indexCategories()
    {
        $categories = Category::all();
        return view('pages.inventories.categories', compact('categories'));
    }

    // Halaman 2: Tabel Barang dengan STATISTIK REAL-TIME
    public function indexItems(Category $category)
    {
        // Kita hitung jumlah anak berdasarkan kondisinya masing-masing
        $items = Inventory::where('category_id', $category->id)
            ->withCount([
                'details as total_unit', // Total semua unit
                'details as baik' => function ($q) {
                    $q->where('condition', \App\Enums\AssetCondition::BAIK->value); },
                'details as rusak_ringan' => function ($q) {
                    $q->where('condition', \App\Enums\AssetCondition::RUSAK_RINGAN->value); },
                'details as rusak_berat' => function ($q) {
                    $q->where('condition', \App\Enums\AssetCondition::RUSAK_BERAT->value); }
            ])
            ->latest()
            ->get();

        return view('pages.inventories.items', compact('category', 'items'));
    }

    // Simpan Barang Induk (HANYA NAMA & KET)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string'
        ]);

        // 1. Simpan ke variabel $inventory agar kita dapat ID-nya
        $inventory = Inventory::create($request->only(['name', 'category_id', 'description']));

        // 2. REDIRECT LANGSUNG ke halaman Detail Unit (asset.index)
        return redirect()->route('asset.index', $inventory->id)
            ->with('success', 'Barang induk dibuat. Silakan input unit fisiknya di bawah ini.');
    }
}