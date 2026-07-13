<?php

namespace Database\Seeders;

use App\Models\Notifikasi;
use Illuminate\Database\Seeder;

class NotifikasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'jenis' => 'pembayaran',
                'judul' => 'Konfirmasi Pembayaran',
                'pesan' => 'Ahmad Wijaya mengirimkan bukti pembayaran sewa kamar bulan ini.',
                'pengirim' => 'Ahmad Wijaya',
                'kamar' => 'A001',
                'data' => ['jumlah' => 1200000],
                'status' => 'belum_dibaca',
                'created_at' => now()->subMinutes(10),
            ],
            [
                'jenis' => 'keluhan',
                'judul' => 'Keluhan Baru',
                'pesan' => 'Siti Nurhaliza melaporkan air di kamar mandi tidak keluar.',
                'pengirim' => 'Siti Nurhaliza',
                'kamar' => 'A003',
                'data' => null,
                'status' => 'belum_dibaca',
                'created_at' => now()->subHour(),
            ],
            [
                'jenis' => 'booking',
                'judul' => 'Booking Kamar Baru',
                'pesan' => 'Dwiyanti Fadilah mengajukan booking untuk kamar tipe standar.',
                'pengirim' => 'Dwiyanti Fadilah',
                'kamar' => 'A005',
                'data' => ['tanggal_masuk' => now()->addDays(3)->format('Y-m-d')],
                'status' => 'belum_dibaca',
                'created_at' => now()->subHours(3),
            ],
            [
                'jenis' => 'pembayaran',
                'judul' => 'Konfirmasi Pembayaran',
                'pesan' => 'Anggia Dwi mengirimkan bukti pembayaran sewa kamar bulan ini.',
                'pengirim' => 'Anggia Dwi',
                'kamar' => 'A004',
                'data' => ['jumlah' => 950000],
                'status' => 'dibaca',
                'created_at' => now()->subDay(),
            ],
            [
                'jenis' => 'keluhan',
                'judul' => 'Keluhan Baru',
                'pesan' => 'Asep melaporkan wifi lemot di area kamar.',
                'pengirim' => 'Asep',
                'kamar' => 'A002',
                'data' => null,
                'status' => 'dibaca',
                'created_at' => now()->subDays(2),
            ],
        ];

        foreach ($data as $row) {
            Notifikasi::create($row);
        }
    }
}
