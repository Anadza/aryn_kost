<?php

namespace Database\Seeders;

use App\Models\Kamar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KamarSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Kamar Standar (A001 - A010)
        |--------------------------------------------------------------------------
        */

        for ($i = 1; $i <= 10; $i++) {

            $noKamar = 'A' . str_pad($i, 3, '0', STR_PAD_LEFT);

            // Atur status kamar
            $status = match ($i) {
                3,4,8 => 'kosong',
                7 => 'booking',
                default => 'terisi',
            };

            Kamar::updateOrCreate(
                ['no_kamar' => $noKamar],
                [
                    'tipe' => 'Standar',
                    'harga' => 1000000,
                    'kapasitas' => 1,
                    'ukuran' => '3 x 4 m',
                    'kasur' => 'Queen Bed',
                    'fasilitas' => 'AC,WiFi,Lemari,Meja Belajar,Kamar Mandi Dalam',
                    'status' => $status,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Kamar Deluxe (B001 - B010)
        |--------------------------------------------------------------------------
        */

        for ($i = 1; $i <= 10; $i++) {

            $noKamar = 'B' . str_pad($i, 3, '0', STR_PAD_LEFT);

            $status = match ($i) {
                2,5 => 'kosong',
                6 => 'booking',
                default => 'terisi',
            };

            Kamar::updateOrCreate(
                ['no_kamar' => $noKamar],
                [
                    'tipe' => 'Deluxe',
                    'harga' => 1500000,
                    'kapasitas' => 2,
                    'ukuran' => '4 x 5 m',
                    'kasur' => 'King Bed',
                    'fasilitas' => 'AC,WiFi,TV,Kulkas,Lemari,Meja Belajar,Water Heater,Kamar Mandi Dalam',
                    'status' => $status,
                ]
            );
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