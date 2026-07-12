<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tagihan;

class TagihanSeeder extends Seeder
{
    public function run(): void
    {

        Tagihan::create([
            'bulan_tagihan' => 'Juni 2026',
            'jumlah_tagihan' => 1000000.00,
            'tanggal_jatuh_tempo' => '2026-06-30',
            'nomor_tagihan' => 'NTB/00234/06/26',
            'status_pembayaran' => 'Belum Dibayar',
        ]);
    }
}
