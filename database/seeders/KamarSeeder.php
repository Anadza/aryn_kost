<?php

namespace Database\Seeders;

use App\Models\Kamar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KamarSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Kamar::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['no_kamar' => 'A001', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'A002', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'A003', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'A004', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'A005', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'A006', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'A007', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'A008', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'A009', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'A010', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'B001', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
            ['no_kamar' => 'B002', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
            ['no_kamar' => 'B003', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
            ['no_kamar' => 'B004', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
            ['no_kamar' => 'B005', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
            ['no_kamar' => 'B006', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
            ['no_kamar' => 'B007', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
            ['no_kamar' => 'B008', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
            ['no_kamar' => 'B009', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
            ['no_kamar' => 'B010', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
        ];

        foreach ($data as $row) {
            Kamar::create($row);
        }
    }
}
