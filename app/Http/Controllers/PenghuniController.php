<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenghuniController extends Controller
{
    /**
     * Dashboard Penghuni
     */
    public function index(): View
    {
        return view('penghuni.dashboard');
    }

    /**
     * Halaman Profil Penghuni
     */
    public function profile(): View
    {
        return view('penghuni.profile_penghuni.edit');
    }

    /**
     * Update Profil Penghuni
     */
    public function updateProfile(Request $request)
    {
        // Akan dikerjakan setelah fitur booking selesai
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