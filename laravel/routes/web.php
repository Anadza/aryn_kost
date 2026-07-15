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
use App\Http\Controllers\Admin\AdminPembayaranController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\Penghuni\PembayaranController;
use App\Http\Controllers\BookingController;

use App\Http\Controllers\Penghuni\NotifikasiController as PenghuniNotifikasiController;

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// Route Otentikasi Umum (Breeze/Jetstream default)
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Utama / Pengalihan (Jika diperlukan)
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Route Profile Global (Cukup tulis sekali di sini, hapus yang ada di dalam role)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Kamar
    Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
    Route::post('/kamar', [KamarController::class, 'store'])->name('kamar.store');
    Route::put('/kamar/{kamar}', [KamarController::class, 'update'])->name('kamar.update');
    Route::delete('/kamar/{kamar}', [KamarController::class, 'destroy'])->name('kamar.destroy');
});

// ==================== ROLE: ADMIN ====================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // CRUD Data Penghuni
        Route::resource('penghuni', DataPenghuniController::class);

        // CRUD Data Kamar
        Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
        Route::post('/kamar', [KamarController::class, 'store'])->name('kamar.store');
        Route::put('/kamar/{kamar}', [KamarController::class, 'update'])->name('kamar.update');
        Route::delete('/kamar/{kamar}', [KamarController::class, 'destroy'])->name('kamar.destroy');

        // Data Pengaduan (Admin)
        Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::patch('/pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.update-status');

        // Data Pembayaran
        Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/pembayaran/{pembayaran}', [AdminPembayaranController::class, 'show'])->name('pembayaran.show');
        Route::put('/pembayaran/{pembayaran}', [AdminPembayaranController::class, 'update'])
            ->middleware('permission:pembayaran.edit')
            ->name('pembayaran.update');

        // Notifikasi
        Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
        Route::patch('/notifikasi/read-all', [NotifikasiController::class, 'readAll'])->name('notifikasi.read-all');
        Route::patch('/notifikasi/{notifikasi}/read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');

        // Route Profil Admin
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/profile/picture', [ProfileController::class, 'store'])->name('profile.store');
    });

    // Admin menyetujui / menolak booking, tetap lewat menu Data Kamar
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::patch('/booking/{booking}/approve', [BookingController::class, 'approve'])
            ->name('booking.approve');
        Route::patch('/booking/{booking}/reject', [BookingController::class, 'reject'])
            ->name('booking.reject');
    });


// ==================== ROLE: OWNER ====================
Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');

        // CRUD Data Penghuni
        Route::resource('penghuni', DataPenghuniController::class);

        // CRUD Data Kamar
        Route::get('/kamar', [KamarController::class, 'index'])->name('kamar.index');
        Route::post('/kamar', [KamarController::class, 'store'])->name('kamar.store');
        Route::put('/kamar/{kamar}', [KamarController::class, 'update'])->name('kamar.update');
        Route::delete('/kamar/{kamar}', [KamarController::class, 'destroy'])->name('kamar.destroy');

        // Data Pengaduan (Owner)
        Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::patch('/pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.update-status');

        // Data Pembayaran
        Route::get('/pembayaran', [AdminPembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/pembayaran/{pembayaran}', [AdminPembayaranController::class, 'show'])->name('pembayaran.show');

        // Route Profil Owner
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/profile/picture', [ProfileController::class, 'store'])->name('profile.store');
    });

// ==================== ROLE: PENGHUNI ====================
Route::middleware(['auth', 'role:penghuni'])
    ->prefix('penghuni')
    ->name('penghuni.')
    ->group(function () {

        Route::get('/dashboard', [PenghuniController::class, 'index'])
            ->name('dashboard');

        // Profile Penghuni

        Route::get('/booking', [PenghuniController::class, 'booking'])
            ->name('booking');

        Route::get('/booking/{kamar}', [PenghuniController::class, 'showBooking'])
            ->name('booking.show');

        Route::get('/booking/{kamar}/confirm', [PenghuniController::class, 'confirmBooking'])
            ->name('booking.confirm');
        Route::get('/dashboard', [PenghuniController::class, 'index'])->name('dashboard');

        // Data pengaduan penghuni
        Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
        Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
        Route::patch('/pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])->name('pengaduan.update-status');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('/profile/picture', [ProfileController::class, 'store'])->name('profile.store');

        // Pembayaran Penghuni
        Route::get('/pembayaran/upload', [PembayaranController::class, 'index'])->name('pembayaran.upload');
        Route::post('/pembayaran/confirm/{id}', [PembayaranController::class, 'confirm'])->name('pembayaran.confirm');

        // Notifikasi Penghuni
        Route::get('/notifikasi', [PenghuniNotifikasiController::class, 'index'])->name('notifikasi.index');
        Route::patch('/notifikasi/read-all', [PenghuniNotifikasiController::class, 'markAllRead'])->name('notifikasi.read-all');
        Route::patch('/notifikasi/{notifikasi}/read', [PenghuniNotifikasiController::class, 'markAsRead'])->name('notifikasi.read');

        // Route Tagihan Penghuni
        Route::get('/tagihan', [PembayaranController::class, 'tagihan'])->name('tagihan.index');
    });

    // Penghuni mengajukan booking
    Route::middleware(['auth', 'role:penghuni'])->group(function () {
        Route::post('/kamar/{kamar}/booking', [BookingController::class, 'store'])
            ->name('booking.store');
    });


require __DIR__ . '/auth.php';
