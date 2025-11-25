<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // LOGIKA PENCARIAN YANG KAMU LUPAKAN
        $units = Unit::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('pages.units.index', compact('units'));
    }

    public function create()
    {
        return view('pages.units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10|unique:units,code',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        Unit::create($request->all());
        return redirect()->route('unit.index')->with('success', 'Unit berhasil ditambahkan.');
    }

    public function show(Unit $unit)
    {
        $rooms = $unit->rooms()->orderBy('name')->get();
        return view('pages.units.show', compact('unit', 'rooms'));
    }

    public function edit(Unit $unit)
    {
        return view('pages.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:10|unique:units,code,' . $unit->id,
            'status' => 'required|in:aktif,non-aktif',
        ]);

        $unit->update($request->all());
        return redirect()->route('unit.index')->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        // Logika defensif kamu saya pertahankan karena ini BENAR
        if ($unit->rooms()->exists()) {
            return back()->withErrors(['Gagal menghapus! Unit ini masih memiliki Ruangan terdaftar. Hapus ruangannya dulu.']);
        }

        $unit->delete();
        return redirect()->route('unit.index')->with('success', 'Unit berhasil dihapus.');
    }
}