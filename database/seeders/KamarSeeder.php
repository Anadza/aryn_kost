<?php

namespace Database\Seeders;

use App\Models\Kamar;
use Illuminate\Database\Seeder;

class KamarSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['no_kamar' => 'A001', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'A002', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'A003', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'kosong'],
            ['no_kamar' => 'A004', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'kosong'],
            ['no_kamar' => 'A005', 'tipe' => 'Standar', 'harga' => 1000000, 'status' => 'terisi'],
            ['no_kamar' => 'A006', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
            ['no_kamar' => 'A007', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'booking'],
            ['no_kamar' => 'A008', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'kosong'],
            ['no_kamar' => 'A009', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
            ['no_kamar' => 'A010', 'tipe' => 'Deluxe', 'harga' => 1500000, 'status' => 'terisi'],
        ];

        foreach ($data as $row) {
            Kamar::updateOrCreate(['no_kamar' => $row['no_kamar']], $row);
        }
    }
}
