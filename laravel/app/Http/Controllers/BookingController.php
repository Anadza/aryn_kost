<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Kamar;
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

        Booking::create([
            'user_id'   => $request->user()->id,
            'kamar_id'  => $kamar->id,
            'durasi'    => $request->validated('durasi'),
            'catatan'   => $request->validated('catatan'),
            'status'    => Booking::STATUS_MENUNGGU,
        ]);

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
        });

        return back()->with('success', 'Booking berhasil disetujui.');
    }

    /**
     * Admin menolak booking.
     */
    public function reject(Booking $booking)
    {
        $booking->update([
            'status' => Booking::STATUS_DITOLAK,
        ]);

        return back()->with('success', 'Booking berhasil ditolak.');
    }
}
