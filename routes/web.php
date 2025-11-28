<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\FundingSourceController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AssetDetailController;
use App\Http\Controllers\ConsumableController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MutationController;
use App\Http\Controllers\DisposalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard Utama
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Group Middleware Auth (Hanya user login yang bisa akses)
Route::middleware('auth')->group(function () {

    // ======================================================================
    // 1. DATA MASTER
    // ======================================================================

    // Unit Kerja / Divisi
    Route::resource('unit', UnitController::class);

    // Ruangan (Paksa parameter jadi {room} agar cocok dengan RoomController)
    Route::resource('ruangan', RoomController::class)->parameters([
        'ruangan' => 'room'
    ]);

    // Sumber Dana (Paksa parameter jadi {sumber_dana})
    Route::resource('sumber-dana', FundingSourceController::class)->parameters([
        'sumber-dana' => 'sumber_dana'
    ]);

    // Manajemen User (Opsional, jika ada fitur admin kelola user)
    Route::resource('users', UserController::class);


    // ======================================================================
    // 2. INVENTARIS ASET TETAP (Barang Modal)
    // ======================================================================

    // Data Induk Barang (Inventory Parent)
    Route::get('/inventaris', [InventoryController::class, 'indexCategories'])->name('inventaris.categories');
    Route::get('/inventaris/kategori/{category}', [InventoryController::class, 'indexItems'])->name('inventaris.items');
    Route::get('/inventaris/create/{category}', [InventoryController::class, 'create'])->name('inventaris.create');
    Route::post('/inventaris/store', [InventoryController::class, 'store'])->name('inventaris.store');
    Route::get('/inventaris/{inventaris}/edit', [InventoryController::class, 'edit'])->name('inventaris.edit');
    Route::put('/inventaris/{inventaris}', [InventoryController::class, 'update'])->name('inventaris.update');
    Route::delete('/inventaris/{inventaris}', [InventoryController::class, 'destroy'])->name('inventaris.destroy');

    // Unit Fisik Aset (Asset Details / Child)
    Route::get('/inventaris/detail/{inventory}', [AssetDetailController::class, 'index'])->name('asset.index');
    Route::get('/asset/create/{inventory}', [AssetDetailController::class, 'create'])->name('asset.create'); // Form Create Terpisah
    Route::post('/asset/store', [AssetDetailController::class, 'store'])->name('asset.store');
    Route::get('/asset/{assetDetail}/edit', [AssetDetailController::class, 'edit'])->name('asset.edit');
    Route::put('/asset/{assetDetail}', [AssetDetailController::class, 'update'])->name('asset.update');
    Route::delete('/asset/{assetDetail}', [AssetDetailController::class, 'destroy'])->name('asset.destroy');


    // ======================================================================
    // 3. BARANG HABIS PAKAI (BHP / Consumables)
    // ======================================================================

    // Kategori & Item Induk BHP
    Route::get('/bhp', [ConsumableController::class, 'indexCategories'])->name('bhp.categories');
    Route::get('/bhp/kategori/{category}', [ConsumableController::class, 'indexItems'])->name('bhp.items');
    Route::get('/bhp/create/{category}', [ConsumableController::class, 'create'])->name('bhp.create');
    Route::post('/bhp/store', [ConsumableController::class, 'store'])->name('bhp.store');

    // Detail Batch Stok (Stok Masuk)
    Route::get('/bhp/create-batch/{consumable}', [ConsumableController::class, 'createBatch'])->name('consumable.createBatch');
    Route::get('/bhp/detail/{consumable}', [ConsumableController::class, 'detail'])->name('consumable.detail');
    Route::post('/bhp/detail/store', [ConsumableController::class, 'storeDetail'])->name('consumable.storeDetail');


    // ======================================================================
    // 4. TRANSAKSI LOGISTIK (Stok Keluar / Mutasi)
    // ======================================================================

    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/keluar', [TransactionController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/store', [TransactionController::class, 'store'])->name('transaksi.store');


    // ======================================================================
    // 5. SIRKULASI PEMINJAMAN ASET
    // ======================================================================

    Route::get('/peminjaman', [LoanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [LoanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman/store', [LoanController::class, 'store'])->name('peminjaman.store');
    // Route khusus untuk proses pengembalian barang
    Route::put('/peminjaman/return/{loan}', [LoanController::class, 'returnItem'])->name('peminjaman.return');

    // Mutasi Aset
    Route::get('/mutasi', [MutationController::class, 'index'])->name('mutasi.index');
    Route::get('/mutasi/create', [MutationController::class, 'create'])->name('mutasi.create');
    Route::post('/mutasi/store', [MutationController::class, 'store'])->name('mutasi.store');
    Route::get('/mutasi/{mutation}', [MutationController::class, 'show'])->name('mutasi.show');
    Route::put('/mutasi/{mutation}/approve', [MutationController::class, 'approve'])->name('mutasi.approve');
    Route::put('/mutasi/{mutation}/reject', [MutationController::class, 'reject'])->name('mutasi.reject');

    // Disposal Aset
    Route::get('/disposal', [DisposalController::class, 'index'])->name('disposals.index');
    Route::get('/disposal/create/{assetDetail}', [DisposalController::class, 'create'])->name('disposals.create');
    Route::post('/disposal/store', [DisposalController::class, 'store'])->name('disposals.store');
    Route::get('/disposal/{disposal}', [DisposalController::class, 'show'])->name('disposals.show');
    Route::get('/disposal/{disposal}/review', [DisposalController::class, 'review'])->name('disposals.review');
    Route::post('/disposal/{disposal}/approve', [DisposalController::class, 'approve'])->name('disposals.approve');
    Route::post('/disposal/{disposal}/reject', [DisposalController::class, 'reject'])->name('disposals.reject');
    Route::get('/disposal/report/pdf', [DisposalController::class, 'exportPdf'])->name('disposals.report.pdf');


    // ======================================================================
    // 6. USULAN PENGADAAN (Procurement)
    // ======================================================================

    Route::resource('pengadaan', ProcurementController::class);
    // Route khusus untuk update status (ACC/Tolak) oleh Admin
    Route::put('/pengadaan/{procurement}/status', [ProcurementController::class, 'updateStatus'])->name('pengadaan.updateStatus');


    // ======================================================================
    // 7. PUSAT LAPORAN (Reporting PDF)
    // ======================================================================

    Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
    Route::get('/laporan/aset', [ReportController::class, 'printAsset'])->name('report.asset');
    Route::get('/laporan/stok', [ReportController::class, 'printConsumable'])->name('report.consumable');
    Route::get('/laporan/pinjam', [ReportController::class, 'printLoan'])->name('report.loan');


    // ======================================================================
    // 8. PROFILE USER (Breeze Default)
    // ======================================================================

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth Routes (Login, Register, Reset Password)
require __DIR__ . '/auth.php';