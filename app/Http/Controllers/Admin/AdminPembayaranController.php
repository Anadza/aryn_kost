<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Models\NotifikasiPenghuni;

class AdminPembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tanggal = $request->input('tanggal');
        $statusFilter = $request->input('status');

        $query = Tagihan::query();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_tagihan', 'like', '%'.$search.'%')
                    ->orWhere('bulan_tagihan', 'like', '%'.$search.'%');
            });
        }

        if (! empty($tanggal)) {
            $query->whereDate('tanggal_upload_bukti', $tanggal);
        }

        if (! empty($statusFilter)) {
            $query->where('status_pembayaran', $statusFilter);
        }

        $pembayarans = $query->latest()->paginate(10)->withQueryString();

        return view('pembayaran.index', compact('pembayarans', 'search', 'tanggal', 'statusFilter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tagihan $pembayaran)
    {
        $pembayaran->load(['penghuni', 'penghuni.kamar']);

        return view('pembayaran.show', compact('pembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tagihan $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tagihan $pembayaran)
    {
        $validated = $request->validate([
            'status_pembayaran' => 'required|in:Belum Dibayar,Menunggu Konfirmasi,Lunas',
        ]);

        $pembayaran->update($validated);

        // Kirim notifikasi ke penghuni terkait, jika tagihan ini sudah tertaut ke penghuni (nama_penghuni)
        if ($pembayaran->nama_penghuni) {
            NotifikasiPenghuni::create([
                'nama_penghuni' => $pembayaran->nama_penghuni,
                'jenis' => 'tagihan',
                'judul' => $validated['status_pembayaran'] === 'Lunas'
                    ? 'Pembayaran Dikonfirmasi'
                    : 'Status Tagihan Diperbarui',
                'pesan' => $validated['status_pembayaran'] === 'Lunas'
                    ? "Pembayaran tagihan {$pembayaran->nomor_tagihan} ({$pembayaran->bulan_tagihan}) sudah dikonfirmasi lunas oleh admin."
                    : "Status tagihan {$pembayaran->nomor_tagihan} ({$pembayaran->bulan_tagihan}) diperbarui menjadi \"{$validated['status_pembayaran']}\".",
                'data' => [
                    'jumlah' => $pembayaran->jumlah_tagihan,
                    'status_pembayaran' => $validated['status_pembayaran'],
                ],
                'status' => 'belum_dibaca',
            ]);
        }

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tagihan $pembayaran)
    {
        //
    }
}
