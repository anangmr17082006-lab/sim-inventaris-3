<?php

namespace App\Http\Controllers;

use App\Models\AssetDetail;
use App\Models\Inventory;
use App\Models\Room;
use App\Models\FundingSource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AssetDetailController extends Controller
{
    // 1. HALAMAN INDEX (CUMA TABEL, BERSIH)
    public function index(Request $request, Inventory $inventory)
    {
        // Kita TIDAK BUTUH $rooms dan $fundings di sini lagi karena formnya pindah

        $query = $inventory->details()->with(['room', 'fundingSource']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('unit_code', 'like', "%$search%")
                    ->orWhere('model_name', 'like', "%$search%")
                    ->orWhereHas('room', function ($subQ) use ($search) {
                        $subQ->where('name', 'like', "%$search%");
                    });
            });
        }

        $details = $query->latest()->paginate(10);

        return view('pages.assets.index', compact('inventory', 'details'));
    }

    // 2. HALAMAN CREATE (KHUSUS FORM) - BARU
    public function create(Inventory $inventory)
    {
        // Data pendukung dropdown pindah ke sini
        $rooms = Room::orderBy('name')->get();
        $fundings = FundingSource::orderBy('name')->get();

        return view('pages.assets.create', compact('inventory', 'rooms', 'fundings'));
    }

    // 3. STORE (SAMA SAJA, Cuma Redirect-nya perlu diperhatikan)
    public function store(Request $request)
    {
        // ... (Validasi SAMA SEPERTI SEBELUMNYA, copy paste aja logic store kamu) ...
        $request->validate([
            'inventory_id' => 'required|exists:inventories,id',
            'model_name' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'funding_source_id' => 'required|exists:funding_sources,id',
            'condition' => 'required',
            'price' => 'nullable|numeric',
            'purchase_date' => 'nullable|date',
            'repair_date' => 'nullable|date',
            'check_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $inventory = Inventory::findOrFail($request->inventory_id);
        $sumber = FundingSource::findOrFail($request->funding_source_id);

        $nextNumber = AssetDetail::where('inventory_id', $inventory->id)->count() + 1;
        $sequence = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $generatedCode = "INV/" . $sumber->code . "/" . $inventory->category_id . "/" . $sequence;

        if (AssetDetail::where('unit_code', $generatedCode)->exists()) {
            $generatedCode .= "-" . strtoupper(Str::random(3));
        }

        AssetDetail::create([
            'unit_code' => $generatedCode,
            'status' => 'tersedia',
            ...$request->all()
        ]);

        // Redirect ke Index setelah simpan
        return redirect()->route('asset.index', $inventory->id)
            ->with('success', 'Unit berhasil ditambahkan. Kode: ' . $generatedCode);
    }

    // ... Method edit, update, destroy biarkan sama
    public function edit(AssetDetail $assetDetail)
    {
        $rooms = Room::orderBy('name')->get();
        return view('pages.assets.edit', compact('assetDetail', 'rooms'));
    }

    public function update(Request $request, AssetDetail $assetDetail)
    {
        $request->validate([
            'model_name' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'condition' => 'required',
            'price' => 'nullable|numeric',
            'purchase_date' => 'nullable|date',
            'repair_date' => 'nullable|date',
            'check_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $assetDetail->update($request->all());
        return redirect()->route('asset.index', $assetDetail->inventory_id)->with('success', 'Update berhasil.');
    }

    public function destroy(AssetDetail $assetDetail)
    {
        $assetDetail->delete();
        return back()->with('success', 'Dihapus.');
    }
}