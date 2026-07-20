<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Booking;
use App\Models\Pengaduan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\NotifikasiPenghuni;

class PengaduanController extends Controller
{
    // Menampilkan Data
    public function index(Request $request): View
    {
        // Jika pengguna adalah penghuni, tampilkan data miliknya saja dengan pagination
        if ($request->user()->hasRole('penghuni')) {
            $pengaduans = Pengaduan::where('penyewa', $request->user()->name)
                ->orderByDesc('id')
                ->paginate(10);
            return view('penghuni.pengaduan.index', compact('pengaduans'));
        }

        // Jika Admin/Owner, hitung statistik total
        $total = Pengaduan::count();
        $sedangDiproses = Pengaduan::whereIn('status', ['pending', 'diproses'])->count();
        $selesai = Pengaduan::where('status', 'selesai')->count();

        // Ambil data pengaduan dengan pagination
        $pengaduans = Pengaduan::orderByDesc('id')->paginate(10);

        // Kirim semua variabel ke view
        return view('pengaduan.index', compact('pengaduans', 'total', 'sedangDiproses', 'selesai'));
    }

    // Menampilkan Form Tambah Keluhan Penghuni
    public function create(): View|RedirectResponse
    {

        $user = Auth::user();

        $booking = Booking::where('user_id', Auth::id())
            ->where('status', Booking::STATUS_DISETUJUI)
            ->first();

        if (!$booking) {
            return redirect()
                ->route('penghuni.pengaduan.index')
                ->with('error', 'Anda hanya dapat mengajukan pengaduan setelah mendapatkan kamar.');
        }

        return view('penghuni.pengaduan.create', compact('booking'));
    }

    // Menyimpan Keluhan Baru
    public function store(Request $request): RedirectResponse
    {
        $booking = $request->user()->bookings()
            ->where('status', Booking::STATUS_DISETUJUI)
            ->first();

        if (!$booking) {
            return redirect()
                ->route('penghuni.pengaduan.index')
                ->with('error', 'Anda hanya dapat mengajukan pengaduan setelah mendapatkan kamar.');
        }

        $request->validate([
            'tanggal'   => 'required|date',
            'kamar'     => 'required|string',
            'kategori'  => 'required|string',
            'deskripsi' => 'required|string',
            'bukti'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $namaFileBukti = null;
        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $namaFileBukti = 'bukti-pengaduan-' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('bukti-pengaduan', $namaFileBukti, 'public');
        }

        Pengaduan::create([
            'tanggal'   => $request->tanggal,
            'penyewa'   => $request->user()->name,
            'kamar'     => $booking->kamar->no_kamar,
            'kategori'  => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'bukti'     => $namaFileBukti,
            'status'    => 'pending',
        ]);

        return redirect()->route('penghuni.pengaduan.index')->with('success', 'Laporan keluhan kamu sudah terkirim ke admin kos.');
    }

    // Mengubah Status Progress Pengaduan (Oleh Admin)
    public function updateStatus(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        // Validasi input status yang dikirim dari form
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai',
        ]);

        // Update status pengaduan
        $pengaduan->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui menjadi: ' . ucfirst($request->status));
    }
}
