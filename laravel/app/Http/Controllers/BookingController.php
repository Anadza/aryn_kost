<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Kamar;
use App\Models\Penghuni;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Penghuni mengajukan booking.
     */
    public function store(StoreBookingRequest $request, Kamar $kamar)
    {
        // Pastikan kamar masih tersedia
        if ($kamar->status !== 'kosong') {
            return back()->with('error', 'Kamar ini sudah tidak tersedia.');
        }

        // Cegah jika masih ada booking yang menunggu
        if ($kamar->pendingBooking()->exists()) {
            return back()->with('error', 'Kamar ini sedang menunggu persetujuan booking.');
        }

        DB::transaction(function () use ($request, $kamar) {
            Booking::create([
                'user_id'   => $request->user()->id,
                'kamar_id'  => $kamar->id,
                'durasi'    => $request->validated('durasi'),
                'catatan'   => $request->validated('catatan'),
                'status'    => Booking::STATUS_MENUNGGU,
            ]);
            $kamar->update([
                'status' => 'booking',
            ]);
        });

        return redirect()
            ->route('penghuni.booking')
            ->with('success', 'Pengajuan booking berhasil dikirim. Silakan menunggu persetujuan admin.');
    }

    /**
     * Admin menyetujui booking.
     */
    public function approve(Booking $booking)
    {
        DB::transaction(function () use ($booking) {

            // Update status booking
            $booking->update([
                'status' => Booking::STATUS_DISETUJUI,
            ]);

            // Update status kamar menjadi terisi
            $booking->kamar->update([
                'status' => 'terisi',
            ]);

            // Tolak semua booking lain yang masih menunggu pada kamar yang sama
            Booking::where('kamar_id', $booking->kamar_id)
                ->where('id', '!=', $booking->id)
                ->where('status', Booking::STATUS_MENUNGGU)
                ->update([
                    'status' => Booking::STATUS_DITOLAK,
                ]);
                $penghuni = Penghuni::where('user_id', $booking->user_id)->first()
                ?? Penghuni::where('nama', $booking->user->name)->first();

                if ($penghuni) {
                    $penghuni->update([
                        'user_id'     => $booking->user_id,
                        'nama'        => $booking->user->name,
                        'nomor_kamar' => $booking->kamar->no_kamar,
                        'check_in'    => $penghuni->check_in ?? now(),
                        'status'      => 'Active',
                    ]);
                } else {
                    Penghuni::create([
                        'user_id'     => $booking->user_id,
                        'nama'        => $booking->user->name,
                        'nomor_kamar' => $booking->kamar->no_kamar,
                        'no_hp'       => '-',
                        'check_in'    => now(),
                        'status'      => 'Active',
                    ]);
                }
        });

        return back()->with('success', 'Booking berhasil disetujui.');
    }

    /**
     * Admin menolak booking.
     */
    public function reject(Booking $booking)
    {
        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => Booking::STATUS_DITOLAK,
            ]);
            $masihAdaYangMenunggu = Booking::where('kamar_id', $booking->kamar_id)
                ->where('status', Booking::STATUS_MENUNGGU)
                ->exists();
                
            if (! $masihAdaYangMenunggu && $booking->kamar->status !== 'terisi') {
                $booking->kamar->update([
                    'status' => 'kosong',
                ]);
            }
        });

        return back()->with('success', 'Booking berhasil ditolak.');
    }
}
