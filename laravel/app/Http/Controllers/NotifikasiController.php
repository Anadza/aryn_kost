<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotifikasiController extends Controller
{
    public function index(Request $request): View
    {
        $jenis = $request->query('jenis', 'semua');

        $notifikasis = Notifikasi::jenis($jenis)
            ->orderByDesc('created_at')
            ->get();

        $semua = Notifikasi::all();

        return view('notifikasi.index', [
            'notifikasis' => $notifikasis,
            'jenisAktif' => $jenis,
            'total' => $semua->count(),
            'belumDibaca' => $semua->where('status', 'belum_dibaca')->count(),
            'totalPembayaran' => $semua->where('jenis', 'pembayaran')->count(),
            'totalKeluhan' => $semua->where('jenis', 'keluhan')->count(),
            'totalBooking' => $semua->where('jenis', 'booking')->count(),
        ]);
    }

    public function markAsRead(Notifikasi $notifikasi): RedirectResponse
    {
        $notifikasi->update(['status' => 'dibaca']);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllRead(): RedirectResponse
    {
        Notifikasi::belumDibaca()->update(['status' => 'dibaca']);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
