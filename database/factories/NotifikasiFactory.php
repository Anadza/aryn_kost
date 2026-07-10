<?php

namespace Database\Factories;

use App\Models\Notifikasi;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotifikasiFactory extends Factory
{
    protected $model = Notifikasi::class;

    public function definition(): array
    {
        $jenis = $this->faker->randomElement(['pembayaran', 'keluhan', 'booking']);

        return [
            'jenis' => $jenis,
            'judul' => match ($jenis) {
                'pembayaran' => 'Konfirmasi Pembayaran',
                'keluhan' => 'Keluhan Baru',
                'booking' => 'Booking Kamar Baru',
            },
            'pesan' => match ($jenis) {
                'pembayaran' => 'Mengirimkan bukti pembayaran sewa kamar.',
                'keluhan' => 'Mengajukan keluhan terkait fasilitas kamar.',
                'booking' => 'Mengajukan booking kamar baru.',
            },
            'pengirim' => $this->faker->name(),
            'kamar' => 'A0'.$this->faker->numberBetween(1, 9),
            'data' => match ($jenis) {
                'pembayaran' => ['jumlah' => $this->faker->numberBetween(800000, 1500000)],
                'booking' => ['tanggal_masuk' => now()->addDays($this->faker->numberBetween(1, 14))->format('Y-m-d')],
                default => null,
            },
            'status' => $this->faker->randomElement(['belum_dibaca', 'belum_dibaca', 'dibaca']),
        ];
    }
}