<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Penghuni;
use Illuminate\View\View;

class TagihanController extends Controller
{
    public function index(Request $request): View
    {
        $penghuniData = Penghuni::with('kamar')->where('user_id', auth()->id())->first();

        $kamarSaya = $penghuniData ? $penghuniData->kamar : null;

        if (!$penghuniData) {
            return view('penghuni.tagihan.index', [
                'penghuniData'      => null,
                'kamarSaya'         => null,
                'tagihanAktif'      => null,
                'riwayatPembayaran' => collect([])->paginate(5)
            ]);
        }

        $tagihanAktif = Tagihan::where('penghuni_id', $penghuniData->id)
            ->whereIn('status_pembayaran', ['Belum Dibayar', 'Menunggu Konfirmasi'])
            ->latest()
            ->first();

        $riwayatPembayaran = Tagihan::where('penghuni_id', $penghuniData->id)
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view('penghuni.tagihan.index', compact(
            'penghuniData',
            'kamarSaya',
            'tagihanAktif',
            'riwayatPembayaran'
        ));
    }
}
