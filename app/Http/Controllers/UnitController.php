<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->paginate(10); // Pakai pagination biar rapi
        return view('pages.units.index', compact('units'));
    }

    public function create()
    {
        return view('pages.units.create');
    }

    public function store(Request $request)
    {
        // Validasi Ketat
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10|unique:units,code',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        Unit::create($request->all());

        return redirect()->route('unit.index')->with('success', 'Unit berhasil ditambahkan.');
    }

    public function edit(Unit $unit)
    {
        return view('pages.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10|unique:units,code,' . $unit->id, // Ignore ID sendiri saat update
            'status' => 'required|in:aktif,non-aktif',
        ]);

        $unit->update($request->all());

        return redirect()->route('unit.index')->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        // Cek apakah unit masih punya ruangan? Jika ya, jangan hapus sembarangan (Opsional, tapi aman)
        if ($unit->rooms()->exists()) {
            return back()->withErrors(['Gagal menghapus! Unit ini masih memiliki Ruangan terdaftar.']);
        }

        $unit->delete();
        return redirect()->route('unit.index')->with('success', 'Unit berhasil dihapus.');
    }

    // MENAMPILKAN DETAIL UNIT & DAFTAR RUANGANNYA
    public function show(Unit $unit)
    {
        // Ambil data ruangan milik unit ini
        // Kita urutkan berdasarkan nama ruangan biar rapi
        $rooms = $unit->rooms()->orderBy('name')->get();

        return view('pages.units.show', compact('unit', 'rooms'));
    }
}