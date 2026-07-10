<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penghuni;

class DataPenghuniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Penghuni::query();

    // Pencarian nama penghuni
    if ($request->filled('search')) {
        $query->where('nama', 'like', '%' . $request->search . '%');
    }

    // Filter status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $penghunis = $query
        ->latest()
        ->paginate(10)
        ->appends($request->query());

    return view('penghuni.index', compact('penghunis'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penghuni.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|max:100',
            'nomor_kamar'  => 'required|max:20',
            'no_hp'     => 'required|max:20',
            'check_in'  => 'required|date',
            'status'    => 'required'
        ]);

        Penghuni::create($validated);

        return redirect()
            ->route('admin.penghuni.index')
            ->with('success', 'Data penghuni berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $penghuni = Penghuni::findOrFail($id);

        return view('penghuni.show', compact('penghuni'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $penghuni = Penghuni::findOrFail($id);

        return view('penghuni.edit', compact('penghuni'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([

            'nama' => 'required|string|max:100',

            'nomor_kamar' => 'required|string|max:20',

            'no_hp' => 'required|string|max:20',

            'check_in' => 'required|date',

            'status' => 'required|in:Active,Inactive',

        ]);

        $penghuni = Penghuni::findOrFail($id);

        $penghuni->update($validated);

        return redirect()
            ->route('admin.penghuni.index')
            ->with('success', 'Data penghuni berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $penghuni = Penghuni::findOrFail($id);

        $penghuni->delete();

        return redirect()
            ->route('admin.penghuni.index')
            ->with('success_delete','Data penghuni berhasil dihapus.');
    }
}
