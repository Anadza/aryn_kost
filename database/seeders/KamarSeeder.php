<?php

namespace Database\Seeders;

use App\Models\Kamar;
use Illuminate\Database\Seeder;

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
        }
    }
}