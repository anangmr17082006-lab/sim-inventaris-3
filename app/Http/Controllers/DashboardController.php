<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetDetail;
use App\Models\ConsumableDetail;
use App\Models\Loan;
use App\Enums\AssetStatus;
use App\Enums\AssetCondition;
use App\Enums\LoanStatus;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan semua data statistik dan peringatan.
     */
    public function index()
    {
        // 1. STATISTIK UTAMA (KARTU ATAS)

        // Total Nilai Aset (Sum Harga Beli semua aset fisik)
        $totalAssetValue = AssetDetail::sum('price');

        // Jumlah Barang Sedang Dipinjam
        $activeLoans = Loan::where('status', LoanStatus::DIPINJAM->value)->count();

        // Jumlah Batch BHP yang Stoknya Menipis (< 5)
        $lowStockCount = ConsumableDetail::where('current_stock', '<', 5)->where('current_stock', '>', 0)->count();

        // 2. DATA WARNING (TABEL)

        // Daftar Peminjam yang TELAT (Lewat Jatuh Tempo & Belum Kembali)
        $lateLoans = Loan::with(['asset.inventory'])
            ->where('status', LoanStatus::DIPINJAM->value)
            ->where('return_date_plan', '<', now()) // Tanggal rencana < Hari ini
            ->get();

        // Daftar Barang BHP yang Hampir Kadaluarsa (1 Bulan ke depan) atau Sudah Expired
        $expiringItems = ConsumableDetail::with('consumable')
            ->whereNotNull('expiry_date')
            ->where('expiry_date', '<', now()->addMonth()) // Kurang dari 30 hari lagi
            ->where('current_stock', '>', 0) // Hanya yang masih ada stoknya
            ->orderBy('expiry_date', 'asc')
            ->limit(5)
            ->get();

        // Daftar Stok Menipis (Limit 5 biar dashboard gak penuh)
        $lowStocks = ConsumableDetail::with('consumable')
            ->where('current_stock', '<', 5)
            ->where('current_stock', '>', 0)
            ->limit(5)
            ->get();


        // --- DATA UNTUK GRAFIK V2.0 ---

        // 1. Grafik Kondisi Aset (Pie Chart)
        // PERBAIKAN: Tambahkan tanda ` (backtick) pada kata condition
        $conditionStats = AssetDetail::selectRaw('`condition`, count(*) as total')
            ->groupBy('condition')
            ->pluck('total', 'condition')
            ->toArray();

        // Siapkan array default agar tidak error jika kondisinya kosong
        $chartCondition = [
            $conditionStats[AssetCondition::BAIK->value] ?? 0,
            $conditionStats[AssetCondition::RUSAK_RINGAN->value] ?? 0,
            $conditionStats[AssetCondition::RUSAK_BERAT->value] ?? 0,
        ];

        // 2. Grafik Peminjaman per Bulan (Line/Bar Chart) - Tahun Ini
        // Kita butuh data 12 bulan ke belakang
        $loansPerMonth = Loan::selectRaw('MONTH(created_at) as month, count(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Rapikan data agar urut Januari - Desember (isi 0 jika kosong)
        $chartLoans = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartLoans[] = $loansPerMonth[$i] ?? 0;
        }


        return view('dashboard', compact(
            'totalAssetValue',
            'activeLoans',
            'lowStockCount',
            'lateLoans',
            'expiringItems',
            'lowStocks',
            'chartCondition', // <--- DATA GRAFIK 1
            'chartLoans'      // <--- DATA GRAFIK 2
        ));
    }
}