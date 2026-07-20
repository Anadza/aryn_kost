<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Penghuni;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncPenghuniFromBookings extends Command
{
    /**
     * Nama & signature command di console.
     */
    protected $signature = 'penghuni:sync-from-bookings';

    /**
     * Penjelasan command.
     */
    protected $description = 'Buat/hubungkan data Penghuni untuk semua booking yang sudah disetujui, termasuk booking lama sebelum fitur auto-link ada. Berguna supaya semua akun penghuni (bukan cuma yang baru di-approve) langsung bisa lihat "Kamar Saya" di dashboard.';

    public function handle(): int
    {
        $bookings = Booking::where('status', Booking::STATUS_DISETUJUI)
            ->with(['user', 'kamar'])
            ->get();

        if ($bookings->isEmpty()) {
            $this->info('Tidak ada booking dengan status disetujui.');

            return self::SUCCESS;
        }

        $dibuat = 0;
        $diupdate = 0;
        $dilewati = 0;

        foreach ($bookings as $booking) {
            if (! $booking->user || ! $booking->kamar) {
                $this->warn("Booking #{$booking->id} dilewati: user atau kamar tidak ditemukan.");
                $dilewati++;

                continue;
            }

            DB::transaction(function () use ($booking, &$dibuat, &$diupdate) {
                $penghuni = Penghuni::where('user_id', $booking->user_id)->first()
                    ?? Penghuni::where('nama', $booking->user->name)->first();

                if ($penghuni) {
                    $penghuni->update([
                        'user_id'     => $booking->user_id,
                        'nama'        => $booking->user->name,
                        'nomor_kamar' => $booking->kamar->no_kamar,
                        'check_in'    => $penghuni->check_in ?? $booking->updated_at ?? now(),
                        'status'      => 'Active',
                    ]);
                    $diupdate++;
                } else {
                    Penghuni::create([
                        'user_id'     => $booking->user_id,
                        'nama'        => $booking->user->name,
                        'nomor_kamar' => $booking->kamar->no_kamar,
                        'no_hp'       => '-',
                        'check_in'    => $booking->updated_at ?? now(),
                        'status'      => 'Active',
                    ]);
                    $dibuat++;
                }
            });
        }

        $this->info("Selesai. Dibuat baru: {$dibuat}, diperbarui: {$diupdate}, dilewati: {$dilewati}.");

        return self::SUCCESS;
    }
}