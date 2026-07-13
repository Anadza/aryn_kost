<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index()
    {
        $tagihan = Tagihan::where('user_id', auth()->id())
                      ->where('status_pembayaran', 'Belum Dibayar')
                      ->latest()
                      ->first();

        $riwayatPembayaran = Tagihan::where('user_id', auth()->id())
                                ->orderByDesc('created_at')
                                ->paginate(5);

        return view('penghuni.pembayaran.upload', compact('tagihan', 'riwayatPembayaran'));
    }
    public function upload(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120', // Maksimal 5MB
        ]);

        $tagihan = Tagihan::findOrFail($id);

        if ($tagihan->bukti_pembayaran_path) {
            Storage::disk('public')->delete($tagihan->bukti_pembayaran_path);
        }

        $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        $tagihan->update([
            'bukti_pembayaran_path' => $path,
            'tanggal_upload_bukti' => now(),
            'status_pembayaran' => 'Menunggu Konfirmasi',
        ]);

        session()->flash('swal_success', 'Bukti pembayaran berhasil diunggah dan akan segera dikonfirmasi.');

        return redirect()->route('penghuni.pembayaran.upload');
    }
}
