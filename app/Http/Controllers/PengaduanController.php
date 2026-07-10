<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Pengaduan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

    public function create(): View
    {
        return view('pengaduan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'required|string|max:1000',
            'tanggal' => 'required|date',
            'kamar' => 'required|string|max:20',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti-pengaduan', 'public');
        }

        $pengaduan = Pengaduan::create([
            'tanggal' => $validated['tanggal'],
            'penyewa' => $request->user()->name,
            'kamar' => $validated['kamar'],
            'kategori' => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'],
            'bukti' => $buktiPath,
            'status' => 'pending',
        ]);

        // Kirim notifikasi otomatis ke admin
        Notifikasi::create([
            'jenis' => 'keluhan',
            'judul' => 'Keluhan Baru',
            'pesan' => $request->user()->name.' mengajukan keluhan: '.Str::limit($validated['deskripsi'], 80),
            'pengirim' => $request->user()->name,
            'kamar' => $validated['kamar'],
            'data' => ['pengaduan_id' => $pengaduan->id, 'kategori' => $validated['kategori']],
            'status' => 'belum_dibaca',
        ]);

        return redirect()->route('penghuni.dashboard')
            ->with('success', 'Keluhan berhasil dikirim. Admin akan segera menindaklanjuti.');
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
