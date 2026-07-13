<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Pembayaran;
use App\Models\Penghuni;
use App\Models\Kamar;

class AdminPembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penghuni = Penghuni::first();
        $kamar = Kamar::first();

        if(!$penghuni || !$kamar) {
            $this->command->info('Gagal membuat seeder pembayaran. Pastikan ada data penghuni dan kamar yang tersedia.');
            return;
        }

        Pembayaran::create([
            'penghuni_id' => $penghuni->id,
            'kamar_id' => $kamar->id,
            'jumlah_bayar' => 1000000,
            'tanggal_bayar' => now(),
            'status' => 'lunas',
        ]);

        Pembayaran::create([
            'penghuni_id' => $penghuni->id,
            'kamar_id' => $kamar->id,
            'jumlah_bayar' => 2000000,
            'tanggal_bayar' => now(),
            'status' => 'belum lunas',
        ]);

        $this->command->info('Seeder pembayaran berhasil ditambahkan.');

    }
}
