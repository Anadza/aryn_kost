<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pengaduan;
use App\Models\Tagihan;
use Illuminate\View\View;

class OwnerController extends Controller
{
    public function index(): View
    {
        $totalKamar = Kamar::count();

        $penyewaAktif = Penghuni::where('status', 'Active')->count();

        $bulanIni = now()->locale('id')->translatedFormat('F Y');

        $pendapatanBulanIni = Tagihan::where('status_pembayaran', 'Lunas')
            ->where('bulan_tagihan', $bulanIni)
            ->sum('jumlah_tagihan');

        $pembayaranTertunda = Tagihan::where('status_pembayaran', '!=', 'Lunas')->count();

        $grafikPemasukan = Tagihan::where('status_pembayaran', 'Lunas')
            ->orderBy('id')
            ->get()
            ->groupBy('bulan_tagihan')
            ->map(fn($group) => $group->sum('jumlah_tagihan'));

        $pengaduanTerbaru = Pengaduan::orderByDesc('id')->take(5)->get();

        return view('owner.dashboard', compact(
            'totalKamar',
            'penyewaAktif',
            'pendapatanBulanIni',
            'pembayaranTertunda',
            'grafikPemasukan',
            'pengaduanTerbaru',
        ));
    }
}
