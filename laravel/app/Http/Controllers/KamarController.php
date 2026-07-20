<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\NotifikasiPenghuni;
use App\Models\RoomDeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KamarController extends Controller
{
    /**
     * Menampilkan daftar kamar.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $statusFilter = (string) $request->query('status', '');

        $query = Kamar::with([
            'pendingBooking.user',
            'latestDeleteRequest',
        ]);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('no_kamar', 'like', "%{$search}%")
                    ->orWhere('tipe', 'like', "%{$search}%");
            });
        }

        if (in_array($statusFilter, ['kosong', 'terisi', 'booking'], true)) {
            $query->where('status', $statusFilter);
        }

        $kamars = $query
            ->orderBy('no_kamar', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('kamar.index', [
            'kamars' => $kamars,
            'search' => $search,
            'statusFilter' => $statusFilter,
        ]);
    }

    /**
     * Menyimpan data kamar baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'no_kamar' => 'required|string|max:20|unique:kamars,no_kamar',
            'tipe'     => 'required|string|max:50',
            'harga'    => 'required|numeric|min:0',
            'status'   => 'required|in:kosong,terisi,booking',
        ]);

        Kamar::create($data);

        return back()->with('success', 'Kamar baru berhasil ditambahkan.');
    }

    /**
     * Mengubah data kamar.
     */
    public function update(Request $request, Kamar $kamar): RedirectResponse
    {
        $data = $request->validate([
            'no_kamar' => 'required|string|max:20|unique:kamars,no_kamar,' . $kamar->id,
            'tipe'     => 'required|string|max:50',
            'harga'    => 'required|numeric|min:0',
            'status'   => 'required|in:kosong,terisi,booking',
        ]);

        $kamar->update($data);

        return back()->with('success', 'Data kamar berhasil diperbarui.');
    }

    /**
     * Menghapus kamar atau mengirim permintaan persetujuan.
     */
    public function destroy(Kamar $kamar): RedirectResponse
    {
        $booking = $kamar->activeBooking;
        dd($booking);
        // 1. Jika kamar kosong, langsung hapus.
        if ($kamar->status === 'kosong') {
            $kamar->delete();

            return back()->with(
                'success',
                'Kamar berhasil dihapus.'
            );
        }

        // 2. Cari booking aktif.
        $booking = $kamar->activeBooking;

        if (!$booking) {
            return back()->with(
                'error',
                'Tidak ditemukan penghuni aktif pada kamar ini.'
            );
        }

        // 3. Ambil request terakhir melalui relasi (bukan query latest()).
        $latestRequest = $kamar->latestDeleteRequest;

        // ===============================
        // MASIH MENUNGGU PERSETUJUAN
        // ===============================
        if ($latestRequest && $latestRequest->status === 'pending') {
            return back()->with(
                'warning',
                'Permintaan penghapusan masih menunggu persetujuan penghuni.'
            );
        }

        // ===============================
        // SUDAH DISETUJUI
        // ===============================
        if ($latestRequest && $latestRequest->status === 'approved') {

            // Hapus booking aktif
            $booking->delete();

            // Hapus seluruh riwayat request kamar ini
            RoomDeleteRequest::where('kamar_id', $kamar->id)->delete();

            // Hapus kamar
            $kamar->delete();

            return back()->with(
                'success',
                'Kamar berhasil dihapus karena penghuni telah menyetujui.'
            );
        }

        // ===============================
        // DITOLAK
        // ===============================
        if ($latestRequest && $latestRequest->status === 'rejected') {

            $latestRequest->update([
                'status' => 'pending',
                'admin_id' => auth()->id(),
                'responded_at' => null,
                'reason' => 'Permintaan penghapusan kamar dikirim ulang oleh admin.',
            ]);

            NotifikasiPenghuni::create([
                'nama_penghuni' => $booking->user->name,
                'jenis' => 'hapus_kamar',
                'judul' => 'Persetujuan Penghapusan Kamar',
                'pesan' => 'Admin kembali meminta persetujuan untuk menghapus kamar ' . $kamar->no_kamar . '.',
                'kamar' => $kamar->no_kamar,
                'data' => [
                    'kamar_id' => $kamar->id,
                    'room_delete_request_id' => $latestRequest->id,
                ],
                'status' => 'belum_dibaca',
            ]);

            return back()->with(
                'success',
                'Permintaan penghapusan berhasil dikirim ulang.'
            );
        }

        // ===============================
        // BELUM PERNAH ADA REQUEST
        // ===============================
        $requestDelete = RoomDeleteRequest::create([
            'kamar_id' => $kamar->id,
            'user_id' => $booking->user_id,
            'admin_id' => auth()->id(),
            'status' => 'pending',
            'reason' => 'Permintaan penghapusan kamar oleh admin.',
        ]);

        NotifikasiPenghuni::create([
            'nama_penghuni' => $booking->user->name,
            'jenis' => 'hapus_kamar',
            'judul' => 'Persetujuan Penghapusan Kamar',
            'pesan' => 'Admin meminta persetujuan untuk menghapus kamar ' . $kamar->no_kamar . '.',
            'kamar' => $kamar->no_kamar,
            'data' => [
                'kamar_id' => $kamar->id,
                'room_delete_request_id' => $requestDelete->id,
            ],
            'status' => 'belum_dibaca',
        ]);

        return back()->with(
            'success',
            'Permintaan penghapusan berhasil dikirim ke penghuni.'
        );
    }
}