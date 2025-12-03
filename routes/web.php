<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\JadwalDokterController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RujukanDigitalController;
use App\Http\Controllers\PembayaranAdminController;
use App\Http\Controllers\FasilitasLayananController;
use App\Http\Controllers\StaffOperasionalController;
use App\Http\Controllers\Auth\RegisteredUserController;

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
Route::get('/tiket_antrian', function () {
    return view('pasien.cari_dokter.tiket_antrian');
})->name('tiket_antrian');

// Booking
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

// Route buat tombol aksi di tabel
Route::post('/admin/reservasi/{id}/confirm', [AdminDashboardController::class, 'confirm'])->name('admin.reservasi.confirm');

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
Route::get('/riwayat_reservasi', function () {
    return view('pasien.riwayat_reservasi.index');
})->name('riwayat_reservasi');


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
Route::middleware('role:staff')->group(function () {
    Route::get('/admin/jadwal-dokter', [JadwalDokterController::class, 'index'])->name('admin.jadwal-dokter');
    Route::post('/admin/jadwal-dokter/store', [JadwalDokterController::class, 'store'])->name('admin.jadwal-dokter.store');
    Route::put('/admin/jadwal-dokter/{id}', [JadwalDokterController::class, 'edit'])->name('admin.jadwal-dokter.edit');

    Route::get('/admin/pembayaran/index', [PembayaranAdminController::class, 'index']);
});
// Rujukan Digital
Route::middleware('role:staff')->group(function () {
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


Route::middleware(['cek_session'])->group(function () {

    // ====================================================
    // 1. TRAFFIC CONTROLLER (Pintu Gerbang Utama)
    // ====================================================
    // Dipanggil oleh tombol "Dashboard" di Sidebar
    Route::get('/staff/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');


    // ====================================================
    // 2. DASHBOARD & VIEW OPERASIONAL (Halaman Tampilan)
    // ====================================================

    // Admin Dashboard (Statistik)
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Resepsionis View
    Route::get('/staff/resepsionis', [StaffOperasionalController::class, 'indexResepsionis'])->name('staff.resepsionis');

    // Perawat View
    Route::get('/staff/perawat', [StaffOperasionalController::class, 'indexPerawat'])->name('staff.perawat');

    // Dokter View
    Route::get('/staff/dokter', [StaffOperasionalController::class, 'indexDokter'])->name('staff.dokter');

    // Kasir View
    Route::get('/staff/kasir', [StaffOperasionalController::class, 'indexKasir'])->name('staff.kasir');


    // ====================================================
    // 3. AKSI OPERASIONAL (POST Form)
    // ====================================================

    // Aksi Resepsionis (Check-In)
    Route::post('/staff/resepsionis/{id}/checkin', [StaffOperasionalController::class, 'checkIn'])->name('staff.resepsionis.checkin');

    // Aksi Perawat (Simpan Vital)
    Route::post('/staff/perawat/{id}/store', [StaffOperasionalController::class, 'storePerawat'])->name('staff.perawat.store');

    // Aksi Dokter (Simpan Diagnosa & Resep) - INI YANG TADI KURANG
    Route::post('/staff/dokter/{id}/store', [StaffOperasionalController::class, 'storeDokter'])->name('staff.dokter.store');

    // Aksi Kasir (Bayar Lunas) - INI YANG TADI KURANG
    Route::post('/staff/kasir/{id}/bayar', [StaffOperasionalController::class, 'storeKasir'])->name('staff.kasir.store');


    // ====================================================
    // 4. MENU KHUSUS ADMIN (Master Data)
    // ====================================================
    // Sesuai menu di Sidebar bagian bawah

    // Halaman Jadwal Dokter
    Route::get('/admin/jadwal', [AdminDashboardController::class, 'viewJadwal'])->name('admin.jadwal-dokter');

    // Halaman Kelola Pegawai
    Route::get('/master/staff', [AdminDashboardController::class, 'viewPegawai'])->name('master.staff'); // Sesuaikan nama route/url

    // Halaman Rujukan (Opsional)
    Route::get('/admin/rujukan', [AdminDashboardController::class, 'viewRujukan'])->name('admin.rujukan-digital');
});


require __DIR__ . '/auth.php';
