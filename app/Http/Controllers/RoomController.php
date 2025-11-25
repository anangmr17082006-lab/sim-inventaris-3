<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Unit;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request) // <--- Tambahkan Request $request
    {
        // Tangkap input search
        $search = $request->input('search');

        $rooms = Room::with('unit')
            ->when($search, function ($query, $search) {
                // Logika pencarian: cari di nama ruangan ATAU lokasi
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('location', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);
            
        return view('pages.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $units = Unit::where('status', 'aktif')->get(); 
        return view('pages.rooms.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'status' => 'required|in:tersedia,perbaikan,digunakan',
        ]);

        Room::create($request->all());
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    // SAYA UBAH $ruangan JADI $room BIAR KONSISTEN
    public function show(Room $room) 
    {
        $assets = $room->assets()
                  ->with(['inventory.category', 'fundingSource'])
                  ->latest()
                  ->get();

        $consumables = $room->consumables()
                       ->with(['consumable', 'fundingSource'])
                       ->where('current_stock', '>', 0)
                       ->latest()
                       ->get();

        // Pass variable sebagai 'ruangan' ke view agar tidak error di blade
        return view('pages.rooms.show', ['ruangan' => $room, 'assets' => $assets, 'consumables' => $consumables]);
    }

    // GANTI $id JADI MODEL BINDING BIAR MODERN
    public function edit(Room $room)
    {
        $units = Unit::where('status', 'aktif')->get();
        return view('pages.rooms.edit', compact('room', 'units'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'status' => 'required|in:tersedia,perbaikan,digunakan',
        ]);

        $room->update($request->all());
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('ruangan.index')->with('success', 'Ruangan dihapus.');
    }
}