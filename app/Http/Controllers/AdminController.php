<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pengaduan;
use App\Models\Tagihan;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        // Total kamar
        $totalKamar = Kamar::count();

        // Total penyewa aktif
        $penyewaAktif = Penghuni::where('status', 'Active')->count();

        // Bulan saat ini
        $bulanIni = now()->locale('id')->translatedFormat('F Y');

        // Pendapatan bulan ini
        $pendapatanBulanIni = Tagihan::where('status_pembayaran', 'Lunas')
            ->sum('jumlah_tagihan');

        // Total seluruh pendapatan
        $totalPendapatan = Tagihan::where('status_pembayaran', 'Lunas')
            ->sum('jumlah_tagihan');

        // Pembayaran yang belum lunas
        $pembayaranTertunda = Tagihan::where('status_pembayaran', '!=', 'Lunas')
            ->count();

        // Grafik pendapatan per bulan
        $grafikPemasukan = Tagihan::where('status_pembayaran', 'Lunas')
            ->get()
            ->groupBy('bulan_tagihan')
            ->map(function ($group) {
                return $group->sum('jumlah_tagihan');
            });

        // Pengaduan terbaru
        $pengaduanTerbaru = Pengaduan::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalKamar',
            'penyewaAktif',
            'pendapatanBulanIni',
            'totalPendapatan',
            'pembayaranTertunda',
            'grafikPemasukan',
            'pengaduanTerbaru'
        ));
    }
}
