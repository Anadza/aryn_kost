<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class OwnerController extends Controller
{
    public function index(): View
    {
        return view('owner.dashboard');
    }
}
