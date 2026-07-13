<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use Illuminate\View\View;

class TagihanController extends Controller
{
    public function index(Request $request): View
    {
        $tagihanBulanIni = Tagihan::where('user_id', auth()->id())
            ->whereIn('status_pembayaran', ['Belum Dibayar', 'Menunggu Konfirmasi'])
            ->latest()
            ->first();

        $riwayatPembayaran = Tagihan::where('user_id', auth()->id())
            ->orderByDesc('id')
            ->paginate(5)
            ->withQueryString();

        return view('penghuni.tagihan.index', compact('tagihanBulanIni', 'riwayatPembayaran'));
    }
}
