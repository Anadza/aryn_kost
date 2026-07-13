<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penghuni;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TambahPenghuniSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Penghuni::truncate();

        User::where('email', 'like', '%@rynkost.com')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $daftarPenghuni = [
            ['nama' => 'Rian Hidayat', 'nomor_kamar' => 'A001', 'no_hp' => '081234567890', 'check_in' => '2026-01-10', 'status' => 'Active'],
            ['nama' => 'Siti Aminah', 'nomor_kamar' => 'A002', 'no_hp' => '081234567891', 'check_in' => '2026-01-12', 'status' => 'Active'],
            ['nama' => 'Budi Santoso', 'nomor_kamar' => 'A003', 'no_hp' => '081234567892', 'check_in' => '2026-02-01', 'status' => 'Active'],
            ['nama' => 'Dewi Lestari', 'nomor_kamar' => 'A004', 'no_hp' => '081234567893', 'check_in' => '2026-02-15', 'status' => 'Active'],
            ['nama' => 'Eko Prasetyo', 'nomor_kamar' => 'A005', 'no_hp' => '081234567894', 'check_in' => '2026-03-01', 'status' => 'Active'],
            ['nama' => 'Fitriani', 'nomor_kamar' => 'A006', 'no_hp' => '081234567895', 'check_in' => '2026-03-10', 'status' => 'Active'],
            ['nama' => 'Gilang Permana', 'nomor_kamar' => 'A007', 'no_hp' => '081234567896', 'check_in' => '2026-04-05', 'status' => 'Active'],
            ['nama' => 'Hani Nuraini', 'nomor_kamar' => 'A008', 'no_hp' => '081234567897', 'check_in' => '2026-04-20', 'status' => 'Active'],
            ['nama' => 'Ira Wijaya', 'nomor_kamar' => 'A009', 'no_hp' => '081234567898', 'check_in' => '2026-05-01', 'status' => 'Active'],
            ['nama' => 'Joko Susilo', 'nomor_kamar' => 'A010', 'no_hp' => '081234567899', 'check_in' => '2026-05-12', 'status' => 'Active'],
            ['nama' => 'Kiki Amelia', 'nomor_kamar' => 'B001', 'no_hp' => '081234567800', 'check_in' => '2026-06-01', 'status' => 'Active'],
            ['nama' => 'Lutfi Hakim', 'nomor_kamar' => 'B002', 'no_hp' => '081234567801', 'check_in' => '2026-06-18', 'status' => 'Active'],
            ['nama' => 'Mega Utami', 'nomor_kamar' => 'B003', 'no_hp' => '081234567802', 'check_in' => '2026-07-01', 'status' => 'Active'],
            ['nama' => 'Naufal Rizqi', 'nomor_kamar' => 'B004', 'no_hp' => '081234567803', 'check_in' => '2026-07-05', 'status' => 'Active'],
            ['nama' => 'Oki Setiawan', 'nomor_kamar' => 'B005', 'no_hp' => '081234567804', 'check_in' => '2026-07-10', 'status' => 'Active'],
            ['nama' => 'Pratiwi Indah', 'nomor_kamar' => 'B006', 'no_hp' => '081234567805', 'check_in' => '2026-07-11', 'status' => 'Active'],
            ['nama' => 'Rendra Prayoga', 'nomor_kamar' => 'B007', 'no_hp' => '081234567806', 'check_in' => '2026-07-12', 'status' => 'Active'],
            ['nama' => 'Siska Amelia', 'nomor_kamar' => 'B008', 'no_hp' => '081234567807', 'check_in' => '2026-07-12', 'status' => 'Active'],
            ['nama' => 'Taufik Hidayat', 'nomor_kamar' => 'B009', 'no_hp' => '081234567808', 'check_in' => '2026-07-12', 'status' => 'Active'],
            ['nama' => 'Wahyu Pratama', 'nomor_kamar' => 'B010', 'no_hp' => '081234567809', 'check_in' => '2026-07-12', 'status' => 'Active'],
        ];

        foreach ($daftarPenghuni as $penghuni) {
            $user = User::create([
                'name' => $penghuni['nama'],
                'email' => Str::slug($penghuni['nama']) . '@rynkost.com',
                'password' => Hash::make('password123'),
            ]);

            if (method_exists($user, 'assignRole')) {
                $user->assignRole('penghuni');
            }

            Penghuni::create([
                'user_id'       => $user->id,
                'nama'          => $penghuni['nama'],
                'nomor_kamar'   => $penghuni['nomor_kamar'],
                'no_hp'         => $penghuni['no_hp'],
                'check_in'      => $penghuni['check_in'],
                'status'        => $penghuni['status'],
            ]);
        }
    }
}
