<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PenghuniController extends Controller
{
    public function index(): View
    {
        return view('penghuni.dashboard');
    }
}
