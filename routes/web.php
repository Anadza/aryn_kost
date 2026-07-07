<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\KamarController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::patch('/pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.update-status');
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::post('/kamar', [KamarController::class, 'store'])->name('kamar.store');
    Route::put('/kamar/{kamar}', [KamarController::class, 'update'])->name('kamar.update');
    Route::delete('/kamar/{kamar}', [KamarController::class, 'destroy'])->name('kamar.destroy');
});

require __DIR__ . '/auth.php';
