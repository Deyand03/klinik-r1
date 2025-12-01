<?php

use App\Http\Controllers\FasilitasLayananController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('beranda');
})->name('beranda');

// Pasien
// Beranda, Login, Regis (Agne)

// Cari Dokter (Zikra)

// Fasilitas & Layanan
Route::get('/pasien/fasilitas-layanan', [FasilitasLayananController::class, 'index'])->name('pasien.fasilitas-layanan');
Route::get('/pasien/fasilitas-layanan/klinik-gigi', [FasilitasLayananController::class, 'klinik_gigi'])->name('fasilitas-layanan.klinik-gigi');
Route::get('/pasien/fasilitas-layanan/klinik-gizi', [FasilitasLayananController::class, 'klinik_gizi'])->name('fasilitas-layanan.klinik-gizi');
Route::get('/pasien/fasilitas-layanan/klinik-umum', [FasilitasLayananController::class, 'klinik_umum'])->name('fasilitas-layanan.klinik-umum');
Route::get('/pasien/fasilitas-layanan/klinik-kulit', [FasilitasLayananController::class, 'klinik_kulit'])->name('fasilitas-layanan.klinik-kulit');
Route::get('/pasien/fasilitas-layanan/klinik-mata', [FasilitasLayananController::class, 'klinik_mata'])->name('fasilitas-layanan.klinik-mata');
Route::get('/pasien/layanan/ambulans', [FasilitasLayananController::class, 'layanansatu'])->name('layanan.satu');
Route::get('/pasien/layanan/pemerikaan mata', [FasilitasLayananController::class, 'layanandua'])->name('layanan.dua');
Route::get('/pasien/layanan/pemerikasaan gigi', [FasilitasLayananController::class, 'layanantiga'])->name('layanan.tiga');
Route::get('/pasien/layanan/mikrodermabrasi', [FasilitasLayananController::class, 'layananempat'])->name('layanan.empat');
Route::get('/pasien/fasilitas/ruang tunggu', [FasilitasLayananController::class, 'fasilitassatu'])->name('fasilitas.satu');
Route::get('/pasien/fasilitas/laboratorium', [FasilitasLayananController::class, 'fasilitasdua'])->name('fasilitas.dua');
Route::get('/pasien/fasilitas/ruang tindakan', [FasilitasLayananController::class, 'fasilitastiga'])->name('fasilitas.tiga');
Route::get('/pasien/fasilitas/farmasi', [FasilitasLayananController::class, 'fasilitasempat'])->name('fasilitas.empat');

// Riwayat Reservasi()


// Admin
// Dashboard

// Rekam Medis

// Pembayaran

// Jadwal Dokter
Route::get('/admin/jadwal-dokter', [JadwalDokterController::class, 'index'])->name('admin.jadwal-dokter');

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
