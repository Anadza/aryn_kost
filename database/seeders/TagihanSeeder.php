<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tagihan;
use App\Models\Penghuni;
use Illuminate\Support\Facades\DB;

class TagihanSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan data lama menggunakan DB statement agar fresh
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Tagihan::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ambil semua data penghuni
        $daftarPenghuni = Penghuni::all();
        $totalPenghuni = $daftarPenghuni->count();

        if ($totalPenghuni === 0) {
            $this->command->warn("Data Penghuni kosong! Jalankan TambahPenghuniSeeder terlebih dahulu.");
            return;
        }

        $daftarBulan = [
            ['nama' => 'Januari 2026', 'angka' => '01'],
            ['nama' => 'Februari 2026', 'angka' => '02'],
            ['nama' => 'Maret 2026', 'angka' => '03'],
            ['nama' => 'April 2026', 'angka' => '04'],
            ['nama' => 'Mei 2026', 'angka' => '05'],
            ['nama' => 'Juni 2026', 'angka' => '06'],
            ['nama' => 'Juli 2026', 'angka' => '07'],
            ['nama' => 'Agustus 2026', 'angka' => '08'],
            ['nama' => 'September 2026', 'angka' => '09'],
            ['nama' => 'Oktober 2026', 'angka' => '10'],
            ['nama' => 'November 2026', 'angka' => '11'],
            ['nama' => 'Desember 2026', 'angka' => '12'],
        ];

        $data = [];
        $counterInvoice = 1;

        // Loop setiap bulan
        foreach ($daftarBulan as $bln) {

            // Acak jumlah kamar yang keluar tagihan di bulan ini
            $jumlahKamarBayar = rand(12, 18);

            for ($i = 0; $i < $jumlahKamarBayar; $i++) {

                // Variasi status pembayaran
                $acak = rand(1, 10);
                if ($acak <= 8) {
                    $status = 'Lunas';
                    $bukti = 'bukti_pembayaran/dummy_sample.jpg';
                    $tglUpload = "2026-{$bln['angka']}-" . str_pad(rand(1, 5), 2, '0', STR_PAD_LEFT) . " 10:00:00";
                } elseif ($acak == 9) {
                    $status = 'Menunggu Konfirmasi';
                    $bukti = 'bukti_pembayaran/dummy_sample.jpg';
                    $tglUpload = "2026-{$bln['angka']}-" . str_pad(rand(5, 10), 2, '0', STR_PAD_LEFT) . " 14:20:00";
                } else {
                    $status = 'Belum Dibayar';
                    $bukti = null;
                    $tglUpload = null;
                }

                // Format nomor tagihan urut: NTB/00001/2026
                $nomorTagihan = 'NTB/' . str_pad($counterInvoice, 5, '0', STR_PAD_LEFT) . '/2026';

                $data[] = [
                    'bulan_tagihan'         => $bln['nama'],
                    'jumlah_tagihan'        => rand(1200, 1800) * 1000,
                    'tanggal_jatuh_tempo'   => "2026-{$bln['angka']}-10",
                    'nomor_tagihan'         => $nomorTagihan,
                    'status_pembayaran'     => $status,
                    'bukti_pembayaran_path' => $bukti,
                    'tanggal_upload_bukti'  => $tglUpload,
                    'created_at'            => now(),
                    'updated_at'            => now(),
                ];

                $counterInvoice++;
            }
        }

        $chunks = array_chunk($data, 100);
        foreach ($chunks as $chunk) {
            Tagihan::insert($chunk);
        }
    }
}
