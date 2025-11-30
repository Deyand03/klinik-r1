<?php

use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PembayaranAdminController;
use App\Http\Controllers\RujukanDigitalController;

Route::get('/', function () {
    return view('beranda');
})->name('beranda');

// Pasien
// Beranda, Login, Regis (Agne)
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// Cari Dokter (Zikra)
Route::get('/cari_dokter', function () {
    return view('pasien.cari_dokter.index');
})->name('cari_dokter');
Route::get('/profil_dokter', function () {
    return view('pasien.cari_dokter.profil_dokter');
})->name('profil_dokter');
Route::get('/pembayaran', function () {
    return view('pasien.cari_dokter.pembayaran');
})->name('pembayaran');

// Fasilitas & Layanan

// Riwayat Reservasi()


// Admin

// Rekam Medis
Route::get('/admin/rekam-medis', [RekamMedisController::class, 'index'])->name('admin.rekam-medis');
Route::post('/rekam-medis/tambah', [RekamMedisController::class, 'store'])->name('rekam.store');


// Dashboard
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/reservasi/{id}/confirm', [AdminDashboardController::class, 'confirm'])
    ->name('admin.reservasi.confirm');
// Rekam Medis (Griyo)

// Pembayaran
// Route::get('/pembayaran/index', [PembayaranController::class, 'index']);


// Jadwal Dokter
Route::middleware('role:staff')->group(function (){
    Route::get('/admin/jadwal-dokter', [JadwalDokterController::class, 'index'])->name('admin.jadwal-dokter');
    Route::post('/admin/jadwal-dokter/store', [JadwalDokterController::class, 'store'])->name('admin.jadwal-dokter.store');
    Route::put('/admin/jadwal-dokter/{id}', [JadwalDokterController::class, 'edit'])->name('admin.jadwal-dokter.edit');

    Route::get('/admin/pembayaran/index', [PembayaranAdminController::class,'index']);
});
// Rujukan Digital
Route::middleware('role:staff')->group(function (){
    Route::get('/admin/rujukan-digital', [RujukanDigitalController::class, 'rujukanDigital'])->name('admin.rujukan-digital');
    Route::post('/admin/rujukan-digital/store', [RujukanDigitalController::class, 'storeRujukanDigital'])->name('admin.rujukan-digital.store');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
