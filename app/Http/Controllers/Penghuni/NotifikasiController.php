<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\NotifikasiPenghuni;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotifikasiController extends Controller
{
    public function index(Request $request): View
    {
        $nama = $request->user()->name;
        $jenis = $request->query('jenis', 'semua');

        $notifikasis = NotifikasiPenghuni::untukPenghuni($nama)
            ->jenis($jenis)
            ->orderByDesc('created_at')
            ->get();

        $semua = NotifikasiPenghuni::untukPenghuni($nama)->get();

        return view('penghuni.notifikasi.index', [
            'notifikasis' => $notifikasis,
            'jenisAktif' => $jenis,
            'total' => $semua->count(),
            'belumDibaca' => $semua->where('status', 'belum_dibaca')->count(),
            'totalBooking' => $semua->where('jenis', 'booking')->count(),
            'totalTagihan' => $semua->where('jenis', 'tagihan')->count(),
            'totalPengaduan' => $semua->where('jenis', 'pengaduan')->count(),
        ]);
    }

    public function markAsRead(Request $request, NotifikasiPenghuni $notifikasi): RedirectResponse
    {
        abort_unless($notifikasi->nama_penghuni === $request->user()->name, 403);

        $notifikasi->update(['status' => 'dibaca']);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        NotifikasiPenghuni::untukPenghuni($request->user()->name)
            ->belumDibaca()
            ->update(['status' => 'dibaca']);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
