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
