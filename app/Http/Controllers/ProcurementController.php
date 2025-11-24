<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use Illuminate\Http\Request;

class ProcurementController extends Controller
{
    // 1. DAFTAR USULAN
    public function index()
    {
        // Urutkan dari yang terbaru
        $requests = Procurement::latest()->paginate(10);
        return view('pages.procurements.index', compact('requests'));
    }

    // 2. FORM USULAN BARU
    public function create()
    {
        return view('pages.procurements.create');
    }

    // 3. SIMPAN USULAN
    public function store(Request $request)
    {
        $request->validate([
            'requestor_name' => 'required|string',
            'item_name' => 'required|string',
            'type' => 'required|in:asset,consumable',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Procurement::create($request->all());

        return redirect()->route('pengadaan.index')->with('success', 'Usulan pengadaan berhasil dikirim ke Admin.');
    }

    // 4. UPDATE STATUS (Hanya Admin yang klik ini nanti)
    public function updateStatus(Request $request, Procurement $procurement)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:approved,rejected,completed',
            'admin_note' => 'nullable|string'
        ]);

        $procurement->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note
        ]);

        return back()->with('success', 'Status pengajuan diperbarui.');
    }

    // HAPUS DATA (Revisi Manual ID)
    public function destroy($id)
    {
        // Cari manual berdasarkan ID, kalau tidak ketemu error 404
        $procurement = Procurement::findOrFail($id);
        
        $procurement->delete();
        
        return back()->with('success', 'Data pengajuan berhasil dihapus.');
    }
}