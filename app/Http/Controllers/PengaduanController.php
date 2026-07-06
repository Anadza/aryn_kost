<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaduanController extends Controller
{
    public function index(): View
    {
        $pengaduans = Pengaduan::orderByDesc('tanggal')->orderByDesc('id')->get();

        $total = $pengaduans->count();
        $sedangDiproses = $pengaduans->whereIn('status', ['pending', 'diproses'])->count();
        $selesai = $pengaduans->where('status', 'selesai')->count();

        return view('pengaduan.index', [
            'pengaduans' => $pengaduans,
            'total' => $total,
            'sedangDiproses' => $sedangDiproses,
            'selesai' => $selesai,
        ]);
    }

    public function updateStatus(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai',
        ]);

        $pengaduan->update(['status' => $request->status]);

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
