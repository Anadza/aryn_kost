<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KamarController extends Controller
{
    // Cari kode yang mirip seperti ini di KamarController kamu:
    public function index(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $kamars = Kamar::query()
            ->when($search, function ($query, $search) {
                $query->where('no_kamar', 'like', "%{$search}%");
            })
            ->when($statusFilter, function ($query, $statusFilter) {
                $query->where('status', $statusFilter);
            })
            ->orderBy('no_kamar', 'asc')
            ->paginate(10);

        return view('kamar.index', compact('kamars', 'search', 'statusFilter'));
    }
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'no_kamar' => 'required|string|max:20|unique:kamars,no_kamar',
            'tipe' => 'required|string|max:50',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:kosong,terisi,booking',
        ]);

        Kamar::create($data);

        return back()->with('success', 'Kamar baru berhasil ditambahkan.');
    }

    public function update(Request $request, Kamar $kamar): RedirectResponse
    {
        $data = $request->validate([
            'no_kamar' => 'required|string|max:20|unique:kamars,no_kamar,' . $kamar->id,
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
