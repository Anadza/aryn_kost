<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataPenghuniController;
use App\Http\Controllers\KamarController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])
    ->get('/dashboard', DashboardController::class)
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');

        // CRUD Data Penghuni
        Route::resource('penghuni', DataPenghuniController::class);

    });

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/dashboard', [OwnerController::class, 'index'])
            ->name('dashboard');

    });

Route::middleware(['auth', 'role:penghuni'])
    ->prefix('penghuni')
    ->name('penghuni.')
    ->group(function () {

        Route::get('/dashboard', [PenghuniController::class, 'index'])
            ->name('dashboard');

    });

Route::middleware('auth')->group(function () {

    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::patch('/pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.update-status');
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::post('/kamar', [KamarController::class, 'store'])->name('kamar.store');
    Route::put('/kamar/{kamar}', [KamarController::class, 'update'])->name('kamar.update');
    Route::delete('/kamar/{kamar}', [KamarController::class, 'destroy'])->name('kamar.destroy');

    Route::get('/pengaduan', [PengaduanController::class, 'index'])
        ->name('pengaduan.index');

    Route::patch('/pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])
        ->name('pengaduan.update-status');

});

require __DIR__.'/auth.php';
