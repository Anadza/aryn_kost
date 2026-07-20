<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KamarController extends Controller
{
    // Cari kode yang mirip seperti ini di KamarController kamu:
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = (string) $request->query('status', '');

        $query = Kamar::with([
            'pendingBooking.user'
        ]);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('no_kamar', 'like', "%{$search}%")
                    ->orWhere('tipe', 'like', "%{$search}%");
            });
        }

        if (in_array($status, ['kosong', 'terisi', 'booking'], true)) {
            $query->where('status', $status);
        }

        $kamars = $query
            ->orderBy('no_kamar')
            ->paginate(10);

        return view('kamar.index', [
            'kamars' => $kamars,
            'search' => $search,
            'statusFilter' => $status,
        ]);
    }
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

    public function update(Request $request, Kamar $kamar): RedirectResponse
    {
        $data = $request->validate([
            'no_kamar' => 'required|string|max:20|unique:kamars,no_kamar,' . $kamar->id,
            'tipe'     => 'required|string|max:50',
            'harga'    => 'required|numeric|min:0',
            'status'   => 'required|in:kosong,terisi,booking',
            'tipe' => 'required|string|max:50',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:kosong,terisi,booking',
        ]);

        $kamar->update($data);

        return back()->with('success', 'Data kamar berhasil diperbarui.');
    }

    public function destroy(Kamar $kamar): RedirectResponse
    {
        $kamar->delete();

        return back()->with('success', 'Kamar berhasil dihapus.');
    }
}
