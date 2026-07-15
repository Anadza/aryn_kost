<?php

use App\Http\Controllers\Api\KostApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\CrudApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Route API untuk aplikasi Flutter (aryn_kost).
| Semua route di file ini secara otomatis mendapat prefix /api.
|
*/

// Autentikasi
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Endpoint dengan middleware auth:sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Dashboard
    Route::get('/dashboard/admin', [DashboardApiController::class, 'admin']);
    Route::get('/dashboard/penghuni', [DashboardApiController::class, 'penghuni']);

    // CRUD Kamar (dengan auth)
    Route::post('/kost', [KostApiController::class, 'store']);
    Route::put('/kost/{kamar}', [KostApiController::class, 'update']);
    Route::delete('/kost/{kamar}', [KostApiController::class, 'destroy']);

    // CRUD Penghuni
    Route::get('/penghuni', [CrudApiController::class, 'penghuniIndex']);
    Route::post('/penghuni', [CrudApiController::class, 'penghuniStore']);
    Route::put('/penghuni/{id}', [CrudApiController::class, 'penghuniUpdate']);
    Route::delete('/penghuni/{id}', [CrudApiController::class, 'penghuniDestroy']);

    // Pengaduan
    Route::get('/pengaduan', [CrudApiController::class, 'pengaduanIndex']);
    Route::patch('/pengaduan/{id}/status', [CrudApiController::class, 'pengaduanUpdateStatus']);

    // Tagihan / Pembayaran
    Route::get('/tagihan', [CrudApiController::class, 'tagihanIndex']);
    Route::put('/tagihan/{id}', [CrudApiController::class, 'tagihanUpdate']);

    // Profil
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // Penghuni-specific endpoints
    Route::get('/my/pengaduan', [CrudApiController::class, 'myPengaduan']);
    Route::post('/my/pengaduan', [CrudApiController::class, 'storePengaduan']);
    Route::get('/my/tagihan', [CrudApiController::class, 'myTagihan']);
    Route::post('/kamar/{id}/booking', [CrudApiController::class, 'storeBooking']);
    Route::post('/tagihan/{id}/confirm', [CrudApiController::class, 'tagihanConfirm']);
    Route::get('/my/notifikasi', [CrudApiController::class, 'myNotifikasi']);
    
    // Admin-specific notification endpoint
    Route::get('/notifikasi', [CrudApiController::class, 'adminNotifikasi']);
});

// Kamar Kost — public (tanpa auth, agar Flutter bisa fetch data)
Route::prefix('kost')->group(function () {
    Route::get('/',         [KostApiController::class, 'index']);    // GET /api/kost
    Route::get('/tersedia', [KostApiController::class, 'tersedia']); // GET /api/kost/tersedia
    Route::get('/{kamar}',  [KostApiController::class, 'show']);     // GET /api/kost/{id}
});
