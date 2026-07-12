<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pengaduan;
use App\Models\Tagihan;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function index(): View
    {
        // Total kamar
        $totalKamar = Kamar::count();

        // Total penyewa aktif
        $penyewaAktif = Penghuni::where('status', 'Active')->count();

        // Nama bulan & tahun saat ini untuk filter (Contoh hasil: "Juli 2026")
        $bulanIniTeks = now()->locale('id')->translatedFormat('F Y');

        // Pendapatan Bulan Ini
$bulanIniTeks = now()->locale('id')->translatedFormat('F Y');

// Filter berdasarkan status Lunas DAN teks bulan berjalan
$pendapatanBulanIni = Tagihan::where('status_pembayaran', 'Lunas')
    ->where('bulan_tagihan', $bulanIniTeks)
    ->sum('jumlah_tagihan');

// Total seluruh pendapatan: Tetap akumulasi total semuanya
$totalPendapatan = Tagihan::where('status_pembayaran', 'Lunas')
    ->sum('jumlah_tagihan');

        // Total Seluruh Pendapatan:
        $totalPendapatan = Tagihan::where('status_pembayaran', 'Lunas')
            ->sum('jumlah_tagihan');

        // Pembayaran Tertunda
        $pembayaranTertunda = Tagihan::where('status_pembayaran', '!=', 'Lunas')->count();

        // Grafik pendapatan per bulan
        $grafikData = Tagihan::where('status_pembayaran', 'Lunas')
            ->select('bulan_tagihan', DB::raw('SUM(jumlah_tagihan) as total'))
            ->selectRaw('MIN(tanggal_jatuh_tempo) as urutan')
            ->groupBy('bulan_tagihan')
            ->orderBy('urutan', 'asc')
            ->get();

        $grafikPemasukan = $grafikData->pluck('total', 'bulan_tagihan');

        // Pengaduan terbaru
        $pengaduanTerbaru = Pengaduan::latest()->paginate(3);

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
