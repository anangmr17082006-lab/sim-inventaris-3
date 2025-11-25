<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Wajib import ini untuk Auth::user()

class ProcurementController extends Controller
{
    // 1. DAFTAR USULAN (DENGAN FILTER & SECURITY)
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        // Mulai Query
        $query = Procurement::query();

        // A. Filter Search (Cari nama barang / pengusul / deskripsi)
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                  ->orWhere('requestor_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // B. Filter Status
        if ($status) {
            $query->where('status', $status);
        }

        // C. Security Check: User biasa cuma boleh lihat usulan sendiri
        // Asumsi kolom 'role' ada di tabel users. Jika tidak ada, hapus blok if ini.
        if (Auth::user()->role != 'admin') {
            $query->where('user_id', Auth::id());
        }

        // Urutkan & Paginate
        $requests = $query->latest()->paginate(10);

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
            'item_name' => 'required|string|max:255',
            'type' => 'required|in:asset,consumable',
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'unit_price_estimation' => 'nullable|numeric', // Validasi harga
        ]);

        // Simpan data dengan memaksa user_id dari sesi Login (Lebih Aman)
        Procurement::create([
            'user_id' => Auth::id(),
            'requestor_name' => Auth::user()->name, // Ambil nama asli akun
            'item_name' => $request->item_name,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'unit_price_estimation' => $request->unit_price_estimation,
            'status' => 'pending',
            'request_date' => now(),
        ]);

        return redirect()->route('pengadaan.index')->with('success', 'Usulan pengadaan berhasil dikirim.');
    }

    // 4. UPDATE STATUS (ACC / TOLAK / SELESAI) - KHUSUS ADMIN
    public function updateStatus(Request $request, Procurement $procurement)
    {
        // Cek apakah yang akses adalah Admin
        if (Auth::user()->role != 'admin') {
            abort(403, 'Anda tidak memiliki izin untuk memproses usulan ini.');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected,completed',
            'admin_note' => 'nullable|string',
        ]);

        $procurement->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
            'response_date' => now(),
        ]);

        return back()->with('success', 'Status usulan diperbarui.');
    }

    // 5. HAPUS DATA
    public function destroy(Procurement $procurement)
    {
        // Logika Keamanan:
        // 1. Admin boleh hapus kapan saja (Opsional)
        // 2. User cuma boleh hapus kalau status masih 'pending' DAN itu punya dia sendiri
        
        $isOwner = $procurement->user_id == Auth::id();
        $isAdmin = Auth::user()->role == 'admin';

        if (!$isAdmin) {
            if (!$isOwner) {
                abort(403, 'Bukan milik Anda.');
            }
            if ($procurement->status != 'pending') {
                return back()->withErrors(['Gagal! Usulan yang sudah diproses tidak bisa dihapus user.']);
            }
        }

        $procurement->delete();
        return back()->with('success', 'Usulan dihapus.');
    }
}