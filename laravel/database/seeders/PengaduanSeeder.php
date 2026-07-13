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
            ['tanggal' => '2026-07-03', 'penyewa' => 'Budi Santoso', 'kamar' => 'A006', 'kategori' => 'Lampu', 'deskripsi' => 'Lampu kamar mati', 'status' => 'pending'],
            ['tanggal' => '2026-07-03', 'penyewa' => 'Dewi Lestari', 'kamar' => 'A007', 'kategori' => 'Air', 'deskripsi' => 'Keran wastafel patah', 'status' => 'pending'],
            ['tanggal' => '2026-07-04', 'penyewa' => 'Eko Prasetyo', 'kamar' => 'A008', 'kategori' => 'Kebersihan', 'deskripsi' => 'Banyak semut', 'status' => 'diproses'],
            ['tanggal' => '2026-07-04', 'penyewa' => 'Fani Amelia', 'kamar' => 'A009', 'kategori' => 'AC', 'deskripsi' => 'AC berisik', 'status' => 'pending'],
            ['tanggal' => '2026-07-05', 'penyewa' => 'Gita Permata', 'kamar' => 'A010', 'kategori' => 'Wifi', 'deskripsi' => 'Koneksi putus-putus', 'status' => 'selesai'],
            ['tanggal' => '2026-07-05', 'penyewa' => 'Hadi Pratama', 'kamar' => 'A011', 'kategori' => 'Air', 'deskripsi' => 'Air berwarna keruh', 'status' => 'pending'],
            ['tanggal' => '2026-07-06', 'penyewa' => 'Indah Sari', 'kamar' => 'A012', 'kategori' => 'Atap', 'deskripsi' => 'Rembes saat hujan', 'status' => 'diproses'],
            ['tanggal' => '2026-07-06', 'penyewa' => 'Joko Anwar', 'kamar' => 'A013', 'kategori' => 'Lampu', 'deskripsi' => 'Saklar lampu rusak', 'status' => 'pending'],
        ];

        foreach ($data as $row) {
            Pengaduan::create($row);
        }
    }
}
