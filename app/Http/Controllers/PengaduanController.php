<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Pengaduan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\NotifikasiPenghuni;

class PengaduanController extends Controller
{
    // Menampilkan Data (Index)
public function index(Request $request)
{
    if ($request->user()->hasRole('penghuni')) {
        // Ambil keluhan milik dia sendiri saja
        $pengaduans = Pengaduan::where('penyewa', $request->user()->name)->orderByDesc('id')->get();
        return view('penghuni.pengaduan.index', compact('pengaduans'));
    }

    // Untuk Admin/Owner
    $pengaduans = Pengaduan::orderByDesc('id')->get();
    return view('pengaduan.index', [
        'pengaduans' => $pengaduans,
        'total' => $pengaduans->count(),
        'sedangDiproses' => $pengaduans->whereIn('status', ['pending', 'diproses'])->count(),
        'selesai' => $pengaduans->where('status', 'selesai')->count(),
    ]);
}

// Menampilkan Form Tambah Keluhan Penghuni
public function create()
{
    return view('penghuni.pengaduan.create');
}

// Menyimpan Keluhan Baru
public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'tanggal'   => 'required|date',
        'kamar'     => 'required|string',
        'kategori'  => 'required|string',
        'deskripsi' => 'required|string',
        'bukti'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Batasi max 2MB
    ]);

    // Handle Upload Bukti Foto jika ada
    $namaFileBukti = null;
    if ($request->hasFile('bukti')) {
        $file = $request->file('bukti');
        // Membuat nama file unik: bukti-pengaduan-171892182.jpg
        $namaFileBukti = 'bukti-pengaduan-' . time() . '.' . $file->getClientOriginalExtension();
        // Simpan ke folder public/storage/bukti-pengaduan
        $file->storeAs('bukti-pengaduan', $namaFileBukti, 'public');
    }

    // Simpan ke database
    Pengaduan::create([
        'tanggal'   => $request->tanggal,
        'penyewa'   => $request->user()->name, // Mengambil nama yang sedang login
        'kamar'     => $request->kamar,
        'kategori'  => $request->kategori,
        'deskripsi' => $request->deskripsi,
        'bukti'     => $namaFileBukti, // Kolom ini sesuaikan dengan nama field di migrasi database kamu
        'status'    => 'pending',
    ]);

        $pengaduan->update(['status' => $request->status]);

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }
    // Update Status Pengaduan (Admin/Owner) + kirim notifikasi ke penghuni
    public function updateStatus(Request $request, Pengaduan $pengaduan): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai',
        ]);

        $pengaduan->update(['status' => $request->status]);

        // Kirim notifikasi ke penghuni saat pengaduan mulai diproses / selesai
        if (in_array($request->status, ['diproses', 'selesai'], true)) {
            NotifikasiPenghuni::create([
                'nama_penghuni' => $pengaduan->penyewa,
                'jenis' => 'pengaduan',
                'judul' => $request->status === 'selesai'
                    ? 'Pengaduan Selesai Diproses'
                    : 'Pengaduan Sedang Diproses',
                'pesan' => $request->status === 'selesai'
                    ? "Pengaduan kamu terkait \"{$pengaduan->kategori}\" sudah selesai ditangani oleh admin kos."
                    : "Pengaduan kamu terkait \"{$pengaduan->kategori}\" sedang diproses oleh admin kos.",
                'kamar' => $pengaduan->kamar,
                'data' => ['pengaduan_id' => $pengaduan->id, 'status' => $request->status],
                'status' => 'belum_dibaca',
            ]);
        }

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
