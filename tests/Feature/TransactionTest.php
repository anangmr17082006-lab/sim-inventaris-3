<?php

use App\Models\User;
use App\Models\Consumable;
use App\Models\ConsumableDetail;
use App\Models\FundingSource;
use App\Models\Category;
use App\Models\Room;
use App\Models\Unit;

test('FIFO Logic: Transaksi mengurangi stok dari batch terlama dulu', function () {
    // 1. PERSIAPAN DATA (ARRANGE)
    // Buat User Login
    $user = User::factory()->create(['role' => 'admin']);
    
    // Buat Data Master Pendukung
    $category = Category::create(['name' => 'BHP Medis', 'type' => 'consumable']);
    $unit = Unit::create(['name' => 'Unit Test']);
    $room = Room::create(['name' => 'Gudang', 'unit_id' => $unit->id, 'location' => 'Lt1']);
    $fund = FundingSource::create(['code' => 'TEST', 'name' => 'Dana Test']);

    // Buat Barang Induk
    $item = Consumable::create(['name' => 'Masker', 'unit' => 'Box', 'category_id' => $category->id]);

    // Buat Batch 1 (LAMA - Expired Duluan) - Stok 10
    $batchLama = ConsumableDetail::create([
        'consumable_id' => $item->id,
        'batch_code' => 'BATCH-OLD',
        'model_name' => 'Merk A',
        'initial_stock' => 10,
        'current_stock' => 10, // Sisa 10
        'funding_source_id' => $fund->id,
        'room_id' => $room->id,
        'created_at' => now()->subMonth(), // Dibuat bulan lalu
    ]);

    // Buat Batch 2 (BARU) - Stok 10
    $batchBaru = ConsumableDetail::create([
        'consumable_id' => $item->id,
        'batch_code' => 'BATCH-NEW',
        'model_name' => 'Merk B',
        'initial_stock' => 10,
        'current_stock' => 10, // Sisa 10
        'funding_source_id' => $fund->id,
        'room_id' => $room->id,
        'created_at' => now(), // Dibuat hari ini
    ]);

    // 2. EKSEKUSI (ACT)
    // Kita minta keluar 15 barang.
    // Harapannya: 10 dari Batch Lama (Habis), 5 dari Batch Baru.
    $response = $this->actingAs($user)
                     ->post(route('transaksi.store'), [
                         'consumable_id' => $item->id,
                         'amount' => 15,
                         'date' => now()->toDateString(),
                         'notes' => 'Test FIFO',
                     ]);

    // 3. PEMBUKTIAN (ASSERT)
    // Pastikan redirect sukses
    $response->assertRedirect(route('transaksi.index'));
    $response->assertSessionHasNoErrors();

    // Cek Database: Batch Lama harusnya 0 (Habis)
    $this->assertDatabaseHas('consumable_details', [
        'id' => $batchLama->id,
        'current_stock' => 0,
    ]);

    // Cek Database: Batch Baru harusnya sisa 5 (10 - 5)
    $this->assertDatabaseHas('consumable_details', [
        'id' => $batchBaru->id,
        'current_stock' => 5,
    ]);
});

test('Stock Guard: Transaksi gagal jika stok total tidak cukup', function () {
    $user = User::factory()->create(['role' => 'admin']);
    
    // BUAT DATA PENDUKUNG DULU (PENTING!)
    $cat = Category::create(['name' => 'BHP Test', 'type' => 'consumable']);
    $fund = FundingSource::create(['code' => 'FS', 'name' => 'Dana']);
    $unit = Unit::create(['name' => 'UT']);
    $room = Room::create(['name' => 'R1', 'unit_id' => $unit->id, 'location' => 'L']);
    
    $item = Consumable::create(['name' => 'Tisu', 'unit' => 'Pcs', 'category_id' => $cat->id]);
    
    // Stok cuma 5
    ConsumableDetail::create([
        'consumable_id' => $item->id,
        'batch_code' => 'BATCH-SINGLE',
        'model_name' => 'Merk A',
        'initial_stock' => 5,
        'current_stock' => 5,
        'funding_source_id' => $fund->id, // Pakai ID valid
        'room_id' => $room->id,           // Pakai ID valid
        'created_at' => now(),
    ]);

    // Minta 10 (Padahal stok 5)
    $response = $this->actingAs($user)
                     ->post(route('transaksi.store'), [
                         'consumable_id' => $item->id,
                         'amount' => 10,
                         'date' => now()->toDateString(),
                         'notes' => 'Test Over Stock',
                     ]);

    $response->assertSessionHasErrors('amount');
});