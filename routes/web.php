<?php

use App\Http\Controllers\UserController; // Pastikan import di atas
use App\Http\Controllers\ProcurementController; // Taruh paling atas
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\FundingSourceController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AssetDetailController;
use App\Http\Controllers\ConsumableController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // --- 1. DATA MASTER ---
    Route::resource('unit', UnitController::class);
    Route::resource('ruangan', RoomController::class);
    Route::resource('sumber-dana', FundingSourceController::class)->parameters([
        'sumber-dana' => 'sumber_dana'
    ]);

    // --- 2. INVENTARIS ASET TETAP (Laptop, Proyektor, dll) ---
    // Halaman Kategori
    Route::get('/inventaris', [InventoryController::class, 'indexCategories'])->name('inventaris.categories');
    // Daftar Barang per Kategori
    Route::get('/inventaris/kategori/{category}', [InventoryController::class, 'indexItems'])->name('inventaris.items');
    // Halaman Tambah Barang
    Route::get('/inventaris/create/{category}', [InventoryController::class, 'create'])->name('inventaris.create');
    // Simpan Barang Induk
    Route::post('/inventaris/store', [InventoryController::class, 'store'])->name('inventaris.store');
    // Update Barang Induk
    Route::put('/inventaris/{inventaris}', [InventoryController::class, 'update'])->name('inventaris.update');
    // Halaman Edit Barang Induk
    Route::get('/inventaris/{inventaris}/edit', [InventoryController::class, 'edit'])->name('inventaris.edit');
    // Hapus Barang Induk
    // Hapus Barang Induk
    Route::delete('/inventaris/{inventaris}', [InventoryController::class, 'destroy'])->name('inventaris.destroy');

    // Detail Unit Aset (Anak)
    Route::get('/inventaris/detail/{inventory}', [AssetDetailController::class, 'index'])->name('asset.index');
    Route::post('/asset/store', [AssetDetailController::class, 'store'])->name('asset.store');
    Route::get('/asset/{assetDetail}/edit', [AssetDetailController::class, 'edit'])->name('asset.edit');
    Route::put('/asset/{assetDetail}', [AssetDetailController::class, 'update'])->name('asset.update');
    Route::delete('/asset/{assetDetail}', [AssetDetailController::class, 'destroy'])->name('asset.destroy');

    // --- 3. BARANG HABIS PAKAI / BHP (Obat, ATK) ---
    Route::get('/bhp', [ConsumableController::class, 'indexCategories'])->name('bhp.categories');
    Route::get('/bhp/kategori/{category}', [ConsumableController::class, 'indexItems'])->name('bhp.items');
    Route::get('/bhp/create/{category}', [ConsumableController::class, 'create'])->name('bhp.create');
    Route::post('/bhp/store', [ConsumableController::class, 'store'])->name('bhp.store');

    // Detail Batch BHP
    Route::get('/bhp/create-batch/{consumable}', [ConsumableController::class, 'createBatch'])->name('consumable.createBatch');
    Route::get('/bhp/detail/{consumable}', [ConsumableController::class, 'detail'])->name('consumable.detail');
    Route::post('/bhp/detail/store', [ConsumableController::class, 'storeDetail'])->name('consumable.storeDetail');

    // --- 4. TRANSAKSI BHP (Stok Masuk/Keluar) ---
    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/keluar', [TransactionController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi/store', [TransactionController::class, 'store'])->name('transaksi.store');

    // --- 5. PEMINJAMAN ASET (Sirkulasi Aset Tetap) ---
    Route::get('/peminjaman', [LoanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [LoanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman/store', [LoanController::class, 'store'])->name('peminjaman.store');
    Route::put('/peminjaman/return/{loan}', [LoanController::class, 'returnItem'])->name('peminjaman.return');

    // --- 6. PENGATURAN (User) ---
    // Placeholder route agar sidebar tidak error
    Route::resource('users', UserController::class);

    // --- 7. LAPORAN (REPORTING) ---
    Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
    Route::get('/laporan/aset', [ReportController::class, 'printAsset'])->name('report.asset');
    Route::get('/laporan/stok', [ReportController::class, 'printConsumable'])->name('report.consumable');
    Route::get('/laporan/pinjam', [ReportController::class, 'printLoan'])->name('report.loan');

    // --- 8. AKUISISI / PENGADAAN ---
    Route::resource('pengadaan', ProcurementController::class);
    // Route khusus untuk update status (ACC/Tolak)
    Route::put('/pengadaan/{procurement}/status', [ProcurementController::class, 'updateStatus'])->name('pengadaan.updateStatus');

    // --- Profile (Breeze Default) ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';