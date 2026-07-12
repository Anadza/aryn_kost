<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenghuniController extends Controller
{
    /**
     * Dashboard Penghuni
     */
    public function index(Request $request): View
    {
        $penghuniData = Penghuni::where('nama', $request->user()->name)->first();

        $kamarSaya = $penghuniData
            ? Kamar::where('no_kamar', $penghuniData->nomor_kamar)->first()
            : null;

        $tagihanAktif = Tagihan::latest()->first();

        $riwayatPembayaran = Tagihan::orderByDesc('id')->skip(1)->take(5)->get();

        return view('penghuni.dashboard', compact(
            'penghuniData',
            'kamarSaya',
            'tagihanAktif',
            'riwayatPembayaran',
        ));
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
        //
    }
}
