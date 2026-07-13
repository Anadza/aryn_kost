<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class PenghuniController extends Controller
{
    /**
     * Dashboard Penghuni
     */
    public function index(Request $request): View
    {
        // 1. Data penghuni & kamar
        $penghuniData = Penghuni::where('nama', $request->user()->name)->first();
        $kamarSaya = $penghuniData
            ? Kamar::where('no_kamar', $penghuniData->nomor_kamar)->first()
            : null;

        // 2. Tagihan Aktif (Milik User yang Login)
        $tagihanAktif = Tagihan::where('user_id', auth()->id())
            ->latest()
            ->first();

        // 3. Riwayat Pembayaran (Milik User yang Login)
        // Sekarang kita filter berdasarkan user_id, bukan berdasarkan ID tagihan
        $riwayatPembayaran = Tagihan::where('user_id', auth()->id())
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view('penghuni.dashboard', compact(
            'penghuniData',
            'kamarSaya',
            'tagihanAktif',
            'riwayatPembayaran',
        ));
    }

    /**
     * Halaman Booking Kamar
     */
    public function booking(Request $request): View
    {
        $query = Kamar::query();

        /*
        |--------------------------------------------------------------------------
        | Filter Tipe Kamar
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Harga
        |--------------------------------------------------------------------------
        */

        if ($request->filled('harga')) {

            switch ($request->harga) {

                case '1000000':
                    $query->where('harga', '<', 1000000);
                    break;

                case '1500000':
                    $query->whereBetween('harga', [1000000, 1500000]);
                    break;

                case '1500001':
                    $query->where('harga', '>', 1500000);
                    break;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        /*
        |--------------------------------------------------------------------------
        | Urutkan berdasarkan nomor kamar
        |--------------------------------------------------------------------------
        */

        $query->orderBy('no_kamar', 'asc');

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $kamars = $query
            ->paginate(6)
            ->withQueryString();

        return view('penghuni.booking.index', compact('kamars'));
    }

    public function showBooking(Kamar $kamar): View
    {
        return view('penghuni.booking.show', compact('kamar'));
    }

    public function confirmBooking(Kamar $kamar): View
    {
        return view('penghuni.booking.confirm', compact('kamar'));
    }
}
