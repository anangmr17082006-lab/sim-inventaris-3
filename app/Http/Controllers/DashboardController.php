<?php

namespace App\Http\Controllers;

use App\Models\AssetDetail;
use App\Models\ConsumableDetail;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB Facade

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1. STATISTIK UTAMA (KARTU ATAS) ---

        // Total Nilai Aset (Sum Harga Beli semua aset fisik)
        $totalAssetValue = AssetDetail::sum('price');

        // Jumlah Barang Sedang Dipinjam
        $activeLoans = Loan::where('status', 'dipinjam')->count();

        // Jumlah Batch BHP yang Stoknya Menipis (< 5 dan > 0)
        $lowStockCount = ConsumableDetail::where('current_stock', '<', 5)
                                         ->where('current_stock', '>', 0)
                                         ->count();


        // --- 2. DATA WARNING (TABEL / LIST) ---

        // Daftar Peminjam yang TELAT (Lewat Jatuh Tempo & Belum Kembali)
        $lateLoans = Loan::with(['asset.inventory'])
            ->where('status', 'dipinjam')
            ->whereDate('return_date_plan', '<', now()) // Tanggal rencana < Hari ini
            ->take(5) // Ambil 5 saja biar tidak kepanjangan
            ->get();

        // Daftar Barang BHP yang Hampir Kadaluarsa (1 Bulan ke depan)
        $expiringItems = ConsumableDetail::with('consumable')
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '>', now()) // Belum expired
            ->whereDate('expiry_date', '<=', now()->addDays(30)) // <= 30 hari lagi
            ->where('current_stock', '>', 0)
            ->orderBy('expiry_date', 'asc')
            ->take(5)
            ->get();

        // Daftar Stok Menipis (Detail List)
        $lowStocks = ConsumableDetail::with('consumable')
            ->where('current_stock', '<', 5)
            ->where('current_stock', '>', 0)
            ->orderBy('current_stock', 'asc')
            ->take(5)
            ->get();


        // --- 3. DATA GRAFIK (CHARTS) ---

        // GRAFIK 1: Kondisi Aset (Donut/Pie Chart)
        // Urutan Array: [Baik, Rusak Ringan, Rusak Berat] - HARUS SESUAI LABEL DI VIEW
        $chartCondition = [
            AssetDetail::where('condition', 'baik')->count(),
            AssetDetail::where('condition', 'rusak_ringan')->count(),
            AssetDetail::where('condition', 'rusak_berat')->count(),
        ];

        // GRAFIK 2: Tren Peminjaman Bulanan (Line/Area Chart) - Tahun Ini
        // Kita buat array kosong untuk 12 bulan
        $chartLoans = [];
        $currentYear = date('Y');

        // Loop bulan 1 sampai 12
        for ($m = 1; $m <= 12; $m++) {
            $count = Loan::whereMonth('loan_date', $m)
                         ->whereYear('loan_date', $currentYear)
                         ->count();
            $chartLoans[] = $count;
        }

        // --- KIRIM SEMUA KE VIEW ---
        return view('dashboard', compact(
            'totalAssetValue',
            'activeLoans',
            'lowStockCount',
            'lateLoans',
            'expiringItems',
            'lowStocks',
            'chartCondition',
            'chartLoans'
        ));
    }
}