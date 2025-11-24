<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
       public function run(): void
    {
        // Panggil semua seeder yang sudah kita buat
        $this->call([
            UserSeeder::class,       // Bikin Admin & Staff
            CategorySeeder::class,   // Bikin Kategori (Elektronik, BHP Medis, dll)
            MasterDataSeeder::class, // Bikin Unit, Ruangan, Sumber Dana
            FakeDataSeeder::class,   // Bikin Transaksi Hantu (Biar Grafik Dashboard bagus)
        ]);
    }
}
