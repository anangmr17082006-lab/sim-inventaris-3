<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Unit;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('unit')->latest()->paginate(10);
        return view('pages.rooms.index', compact('rooms'));
    }

    public function create()
    {
        // Kirim data unit agar bisa dipilih di dropdown
        $units = Unit::where('status', 'aktif')->get(); 
        return view('pages.rooms.create', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id', // Validasi relasi
            'status' => 'required|in:tersedia,perbaikan,digunakan',
        ]);

        Room::create($request->all());
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    // MENAMPILKAN DETAIL ISI RUANGAN
    public function show(Room $ruangan)
    {
        // Ambil Data Aset Tetap di ruangan ini
        $assets = $ruangan->assets()
                  ->with(['inventory.category', 'fundingSource']) // Load data induknya
                  ->latest()
                  ->get();

        // Ambil Data BHP di ruangan ini (yang stoknya masih ada)
        $consumables = $ruangan->consumables()
                       ->with(['consumable', 'fundingSource'])
                       ->where('current_stock', '>', 0)
                       ->latest()
                       ->get();

        return view('pages.rooms.show', compact('ruangan', 'assets', 'consumables'));
    }

   public function edit($id)
    {
        // 1. Cari data ruangan berdasarkan ID
        $room = Room::findOrFail($id);
        
        // 2. Ambil data unit untuk dropdown
        $units = Unit::where('status', 'aktif')->get();

        // 3. Kirim ke View dengan nama variabel 'room' (BUKAN 'ruangan')
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