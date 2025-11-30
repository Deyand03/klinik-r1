<?php

use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('beranda');
})->name('beranda');

// Pasien
// Beranda, Login, Regis (Agne)

// Cari Dokter (Zikra)

// Fasilitas & Layanan

// Riwayat Reservasi()


// Admin
// Dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Rekam Medis

// Pembayaran

// Jadwal Dokter
Route::get('/admin/jadwal-dokter', [JadwalDokterController::class, 'index'])->name('admin.jadwal-dokter');
Route::post('/admin/reservasi/{id}/confirm', [AdminDashboardController::class, 'confirm'])
    ->name('admin.reservasi.confirm');

// Rujukan Digital


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
