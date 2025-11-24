<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory;
use Carbon\Carbon;

class FakeDataSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah ada data aset untuk dipinjam
        $inventory = Inventory::with('details')->first();

        // Jika tidak ada data aset, skip saja agar tidak error
        if (!$inventory || $inventory->details->count() == 0) {
            return;
        }

        $assetDetail = $inventory->details->first();
        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 50; $i++) {
            $loanDate = Carbon::create(date('Y'), rand(1, 11), rand(1, 28));
            $returnDate = (clone $loanDate)->addDays(rand(1, 7));

            DB::table('loans')->insert([
                'asset_detail_id' => $assetDetail->id,
                'borrower_name' => $faker->name,
                'borrower_id' => $faker->numerify('##########'),
                'phone' => $faker->phoneNumber,
                'loan_date' => $loanDate,
                'return_date_plan' => $returnDate,
                'return_date_actual' => $returnDate,
                'status' => 'kembali',
                'notes' => 'Data Dummy Grafik',
                'created_at' => $loanDate,
                'updated_at' => $returnDate,
            ]);
        }
    }
}