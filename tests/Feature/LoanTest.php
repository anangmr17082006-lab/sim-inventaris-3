<?php

use App\Models\User;
use App\Models\Inventory;
use App\Models\AssetDetail;
use App\Models\Category;
use App\Models\Room;
use App\Models\Unit;
use App\Models\FundingSource;

test('Guardrail: Tidak bisa meminjam aset yang statusnya DIPINJAM', function () {
    // 1. ARRANGE
    $user = User::factory()->create(['role' => 'admin']);
    
    // Data Pendukung
    $cat = Category::create(['name' => 'Elektronik']);
    $unit = Unit::create(['name' => 'UT']);
    $room = Room::create(['name' => 'Lab', 'unit_id' => $unit->id, 'location' => 'A']);
    $fund = FundingSource::create(['code' => 'FS', 'name' => 'Dana']);
    $inv = Inventory::create(['name' => 'Laptop', 'category_id' => $cat->id]);

    // Buat Aset dengan status 'dipinjam'
    $asset = AssetDetail::create([
        'inventory_id' => $inv->id,
        'unit_code' => 'LPT-01',
        'model_name' => 'Asus',
        'status' => 'dipinjam', // <--- SUDAH DIPINJAM
        'condition' => 'baik',
        'room_id' => $room->id,
        'funding_source_id' => $fund->id
    ]);

    // 2. ACT
    // Coba paksa pinjam lagi
    $response = $this->actingAs($user)
                     ->post(route('peminjaman.store'), [
                         'asset_detail_id' => $asset->id,
                         'borrower_name' => 'Budi',
                         'borrower_id' => '123',
                         'loan_date' => now()->toDateString(),
                         'return_date_plan' => now()->addDay()->toDateString(),
                     ]);

    // 3. ASSERT
    // Harusnya gagal dan ada error message
    $response->assertSessionHasErrors();
});

test('Guardrail: Tidak bisa meminjam aset yang KONDISINYA RUSAK', function () {
    // 1. ARRANGE
    $user = User::factory()->create(['role' => 'admin']);
    
    // Buat Data Pendukung Manual (Tanpa Factory)
    $cat = Category::create(['name' => 'Elektronik Test', 'type' => 'asset']); // Pastikan type 'asset'
    $unit = Unit::create(['name' => 'UT']);
    $room = Room::create(['name' => 'Lab', 'unit_id' => $unit->id, 'location' => 'A']);
    $fund = FundingSource::create(['code' => 'FS', 'name' => 'Dana']);
    $inv = Inventory::create(['name' => 'Laptop Rusak', 'category_id' => $cat->id]);

    // Buat Aset 'Rusak Berat'
    $asset = AssetDetail::create([
        'inventory_id' => $inv->id,
        'unit_code' => 'RUSAK-01',
        'model_name' => 'Asus X',
        'status' => 'tersedia', // Status tersedia, TAPI...
        'condition' => 'rusak_berat', // ...Kondisinya Rusak
        'room_id' => $room->id,
        'funding_source_id' => $fund->id
    ]);

    // 2. ACT
    $response = $this->actingAs($user)
                     ->post(route('peminjaman.store'), [
                         'asset_detail_id' => $asset->id,
                         'borrower_name' => 'Budi',
                         'borrower_id' => '123',
                         'loan_date' => now()->toDateString(),
                         'return_date_plan' => now()->addDay()->toDateString(),
                     ]);

    // 3. ASSERT
    // Harusnya gagal dan ada error message (karena validasi di controller)
    $response->assertSessionHasErrors();
});