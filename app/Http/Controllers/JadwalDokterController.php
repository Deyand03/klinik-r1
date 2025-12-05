<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class JadwalDokterController extends Controller
{
    public function index(Request $request)
    {
        $token = session('api_token');

        // 1. Ambil List Klinik untuk Filter
        $responseKlinik = Http::withToken($token)->get(env('API_URL') . '/admin/jadwal-dokter/list-klinik');
        $clinics = $responseKlinik->successful() ? $responseKlinik->json()['data'] : [];

        // 2. Ambil Jadwal (Kirim parameter filter klinik)
        $responseJadwal = Http::withToken($token)
            ->get(env('API_URL') . '/admin/jadwal-dokter', [
                'clinic_id' => $request->clinic_id, // Filter Klinik dari View
                'search' => $request->search,
                'hari' => $request->hari
            ]);

        $schedules = $responseJadwal->successful() ? $responseJadwal->json()['data'] : [];

        return view('admin.jadwal_dokter.index', compact('schedules', 'clinics'));
    }

    public function create(Request $request)
    {
        $token = session('api_token');

        // 1. Ambil List Klinik (Buat Admin milih klinik mana yg mau ditambah jadwalnya)
        $responseKlinik = Http::withToken($token)->get(env('API_URL') . '/admin/jadwal-dokter/list-klinik');
        $clinics = $responseKlinik->successful() ? $responseKlinik->json()['data'] : [];

        // 2. Ambil List Dokter
        // Kalau user milih klinik di view, halaman reload bawa param ?clinic_id=X
        // API getDoctorsList akan menyesuaikan isi dokter berdasarkan clinic_id itu.
        $clinicId = $request->query('clinic_id');

        $responseDokter = Http::withToken($token)
            ->get(env('API_URL') . '/admin/jadwal-dokter/list-dokter', [
                'clinic_id' => $clinicId, // Kirim ID klinik yg dipilih
            ]);

        $doctors = $responseDokter->successful() ? $responseDokter->json()['data'] : [];

        return view('admin.jadwal_dokter.create', compact('doctors', 'clinics', 'clinicId'));
    }

    public function edit($staffId)
    {
        $token = session('api_token');

        // Ambil detail (bisa via index filter staff_id untuk hemat endpoint)
        // Atau buat endpoint show khusus di backend (recommended), tapi pakai index filter ok juga.
        $responseJadwal = Http::withToken($token)
            ->get(env('API_URL') . '/admin/jadwal-dokter'); // Ambil semua dulu (atau filter by clinic_id user)

        $allSchedules = $responseJadwal->successful() ? $responseJadwal->json()['data'] : [];
        $targetSchedule = collect($allSchedules)->firstWhere('staff_id', $staffId);

        if (!$targetSchedule) {
            return back()->with('error', 'Data jadwal tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $currentSchedule = $targetSchedule['details'] ?? [];
        $dokterName = $targetSchedule['dokter'];
        $klinikName = $targetSchedule['klinik'] ?? ''; // Nama klinik buat info

        return view('admin.jadwal_dokter.edit', compact('staffId', 'currentSchedule', 'dokterName', 'klinikName'));
    }

    // --- STORE & UPDATE TETAP SAMA ---
    public function store(Request $request) {
        $token = session('api_token');
        $payload = ['staff_id' => $request->staff_id, 'jadwal' => $request->jadwal];

        $response = Http::withToken($token)->post(env('API_URL') . '/admin/jadwal-dokter/store', $payload);

        if ($response->successful()) return redirect()->route('admin.jadwal-dokter.index')->with('success', 'Jadwal baru berhasil ditambahkan!');
        if ($response->status() == 422) return back()->with('error', 'Gagal: ' . ($response->json()['message'] ?? 'Validasi gagal'))->withInput();
        return back()->with('error', 'Terjadi kesalahan pada server.')->withInput();
    }

    public function update(Request $request, $staffId) {
        $token = session('api_token');
        $payload = ['jadwal' => $request->jadwal];

        $response = Http::withToken($token)->put(env('API_URL') . '/admin/jadwal-dokter/update/' . $staffId, $payload);

        if ($response->successful()) return redirect()->route('admin.jadwal-dokter.index')->with('success', 'Jadwal berhasil diperbarui!');
        return back()->with('error', 'Gagal update: ' . ($response->json()['message'] ?? 'Error server'));
    }
}
