<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\FasilitasLayananController;
use App\Http\Controllers\StaffOperasionalController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Note: Route Login/Logout/Password Reset harus tetap di-load dari require __DIR__ . '/auth.php';

// ====================================================
// I. PUBLIC & PASIEN GUEST ACCESS
// ====================================================

// Route Landing Page
Route::get('/', function () {
    return view('beranda');
})->name('beranda');

// --- Pendaftaran (Register) ---
Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');

// Booking Views
Route::get('/cari_dokter', function () {
    return view('pasien.cari_dokter.index');
})->name('cari_dokter');
Route::get('/profil_dokter', function () {
    return view('pasien.cari_dokter.profil_dokter');
})->name('profil_dokter');

// --- FASILITAS & LAYANAN (Total 13 Views) ---
Route::controller(FasilitasLayananController::class)->group(function () {

    Route::get('/pasien/fasilitas-layanan', 'index')->name('pasien.fasilitas-layanan'); // Main index page

    // I. KLINIK DETAILS (5 POLI)
    Route::prefix('pasien/klinik')->name('fasilitas-layanan.')->group(function () {
        Route::get('/umum', 'klinik_umum')->name('klinik-umum');
        Route::get('/gigi', 'klinik_gigi')->name('klinik-gigi');
        Route::get('/mata', 'klinik_mata')->name('klinik-mata');
        Route::get('/gizi', 'klinik_gizi')->name('klinik-gizi');
        Route::get('/kulit', 'klinik_kulit')->name('klinik-kulit');
    });

    // II. LAYANAN DETAIL (4 SERVICES)
    Route::prefix('pasien/layanan')->name('layanan.')->group(function () {
        Route::get('/ambulans', 'layanansatu')->name('satu'); //
        Route::get('/pemeriksaan-mata', 'layanandua')->name('dua'); //
        Route::get('/pemeriksaan-gigi', 'layanantiga')->name('tiga'); //
        Route::get('/mikrodermabrasi', 'layananempat')->name('empat'); //
    });

    // III. FASILITAS DETAIL (4 FACILITIES)
    Route::prefix('pasien/fasilitas')->name('fasilitas.')->group(function () {
        Route::get('/ruang-tunggu', 'fasilitassatu')->name('satu'); //
        Route::get('/laboratorium', 'fasilitasdua')->name('dua'); //
        Route::get('/ruang-tindakan', 'fasilitastiga')->name('tiga'); //
        Route::get('/farmasi', 'fasilitasempat')->name('empat'); //
    });
});


// ====================================================
// II. ROUTE TERAUTENTIKASI (PASIEN & STAFF)
// ====================================================

// Grup Utama: Memastikan token API tersedia di session
Route::middleware(['cek_session'])->group(function () {
    // --- 1. PASIEN FLOW & VIEWS ---
    Route::get('/tiket_antrian', function () {
        return view('pasien.cari_dokter.tiket_antrian');
    })->name('tiket_antrian');
    Route::get('/riwayat_reservasi', function () {
        return view('pasien.riwayat_reservasi.index');
    })->name('riwayat_reservasi');

    // Booking Action (Membuat Kunjungan)
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

    // Profile Settings (Breeze Default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- 2. STAFF OPERASIONAL & ADMIN ---
    // Semua route di bawah ini hanya untuk role: staff/admin (dibatasi oleh middleware role:staff)
    Route::prefix('staff')->middleware(['role:staff'])->group(function () {


        Route::post('/perawat/input-vital/{id}', [DashboardController::class, 'storeVital'])
            ->name('staff.perawat.input-vital');

        // A. TRAFFIC CONTROLLER & DASHBOARD (GET)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');

        Route::post('/dashboard', [DashboardController::class, 'store'])
            ->name('staff.dashboard.store');

        // B. ACTIONS OPERASIONAL (POST)
        // Semua aksi diarahkan ke DashboardController (Konsolidasi)
        Route::controller(DashboardController::class)->group(function () {

            Route::post('/resepsionis/{id}/checkin', 'checkIn')->name('staff.resepsionis.checkin');
            Route::post('/perawat/{id}/store', 'storePerawat')->name('staff.perawat.store');
            Route::post('/dokter/{id}/store', 'storeDokter')->name('staff.dokter.store');
            Route::post('/kasir/{id}/bayar', 'storeKasir')->name('staff.kasir.store');
        });

        // D. ADMIN MASTER DATA & REPORTING
        Route::controller(AdminDashboardController::class)->prefix('admin')->group(function () {

            Route::get('/dashboard', 'index')->name('admin.dashboard'); // Dashboard Statistik
            Route::get('/master/staff', 'viewPegawai')->name('master.staff');
            Route::get('/rekam-medis', 'viewRekamMedis')->name('admin.rekam-medis');
            Route::get('/rujukan', 'viewRujukan')->name('admin.rujukan-digital');
        });

        Route::get('/admin/jadwal-dokter', [JadwalDokterController::class, 'index'])->name('admin.jadwal-dokter');
        Route::post('/admin/jadwal-dokter/store', [JadwalDokterController::class, 'store'])->name('admin.jadwal-dokter.store');
        Route::put('/admin/jadwal-dokter/{id}', [JadwalDokterController::class, 'edit'])->name('admin.jadwal-dokter.edit');
    });
});




// Note: Pastikan file 'auth.php' sudah ada di folder routes.
require __DIR__ . '/auth.php';
