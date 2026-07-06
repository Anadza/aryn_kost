<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use Illuminate\Database\Seeder;

class PengaduanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['tanggal' => '2026-07-02', 'penyewa' => 'Ahmad Wijaya', 'kamar' => 'A001', 'kategori' => 'AC', 'deskripsi' => 'AC tidak dingin', 'status' => 'selesai'],
            ['tanggal' => '2026-07-02', 'penyewa' => 'Asep', 'kamar' => 'A002', 'kategori' => 'Wifi', 'deskripsi' => 'Wifi lemot', 'status' => 'selesai'],
            ['tanggal' => '2026-07-02', 'penyewa' => 'Siti Nurhaliza', 'kamar' => 'A003', 'kategori' => 'Air', 'deskripsi' => 'Air tidak keluar', 'status' => 'pending'],
            ['tanggal' => '2026-07-02', 'penyewa' => 'Anggia Dwi', 'kamar' => 'A004', 'kategori' => 'Atap', 'deskripsi' => 'Atap bocor', 'status' => 'diproses'],
            ['tanggal' => '2026-07-02', 'penyewa' => 'Dwiyanti Fadilah', 'kamar' => 'A005', 'kategori' => 'Wifi', 'deskripsi' => 'Wifi lemot', 'status' => 'selesai'],
        ];

        foreach ($data as $row) {
            Pengaduan::create($row);
        }
    }
}
