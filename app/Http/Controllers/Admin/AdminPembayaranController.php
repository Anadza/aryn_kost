<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Pembayaran;
use Illuminate\Http\Request;

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

    $query = Pembayaran::with(['penghuni', 'kamar']);

    if (!empty($search)) {
        $query->whereHas('penghuni', function ($q) use ($search) {
            $q->where('nama', 'like', '%' . $search . '%');
        });
    }

    if (!empty($tanggal)) {
        $query->whereDate('tanggal_bayar', $tanggal);
    }

    if (!empty($statusFilter)) {
        $query->where('status', $statusFilter);
    }

    $pembayarans = $query->latest()->paginate(10);

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
    public function store(Pembayaran $pembayaran)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        $pembayaran -> load(['penghuni', 'penghuni.kamar']);

        return view('pembayaran.show', compact('pembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $validasiData = $request->validate([
            'status' => 'required|in:belum lunas,lunas',
        ]);

        $pembayaran->update([
            'status' => $validasiData['status'],
        ]);

        return redirect()
            ->route('admin.pembayaran.show', $pembayaran -> id)
            ->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
