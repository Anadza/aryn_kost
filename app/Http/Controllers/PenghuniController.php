<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PenghuniController extends Controller
{
    /**
     * Dashboard Penghuni
     */
    public function index(): View
    {
        return view('penghuni.dashboard');
    }

    /**
     * Halaman Profil Penghuni
     */
    public function profile(): View
    {
        return view('penghuni.profile_penghuni.edit');
    }

    /**
     * Update Profil Penghuni
     */
    public function updateProfile(Request $request)
    {
        //
    }
}