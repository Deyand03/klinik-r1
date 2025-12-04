<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class JadwalDokterController extends Controller
{
    // --- HALAMAN INDEX (DAFTAR) ---
    public function index(Request $request)
    {
        $token = session('api_token');
        $user = session('user_data');
        $clinicId = $user['staff']['id_klinik'] ?? null;
        $staff = $user['staff'] ?? null;

        // Ambil data jadwal dari Backend
        // Mendukung pencarian via query param 'search' dan 'hari' dari form GET
        $responseJadwal = Http::withToken($token)
            ->get(env('API_URL') . '/admin/jadwal-dokter', [
                'clinic_id' => $clinicId,
                'staff' => $staff,
                'search' => $request->search, // Kirim search query
                'hari' => $request->hari      // Kirim filter hari
            ]);

        $schedules = $responseJadwal->successful() ? $responseJadwal->json()['data'] : [];

        return view('admin.jadwal_dokter.index', compact('schedules'));
    }

    // --- HALAMAN CREATE (TAMBAH) ---
    public function create()
    {
        $token = session('api_token');
        $user = session('user_data');
        $clinicId = $user['staff']['id_klinik'] ?? null;
        $staff = $user['staff'] ?? null;

        // Ambil list dokter buat dropdown
        $responseDokter = Http::withToken($token)
            ->get(env('API_URL') . '/admin/jadwal-dokter/list-dokter', [
                'clinic_id' => $clinicId,
                'staff' => $staff,
            ]);

        $doctors = $responseDokter->successful() ? $responseDokter->json()['data'] : [];

        return view('admin.jadwal_dokter.create', compact('doctors'));
    }

    // --- HALAMAN EDIT (UBAH) ---
    public function edit($staffId)
    {
        $token = session('api_token');
        $user = session('user_data');
        $clinicId = $user['staff']['id_klinik'] ?? null;
        $staff = $user['staff'] ?? null;

        // Ambil data detail jadwal dokter ini dari Backend
        // Kita bisa reuse endpoint index tapi difilter staff_id, atau endpoint khusus show
        // Untuk simpelnya, kita ambil semua dan filter di PHP (atau request detail ke backend)

        // Agar efisien, sebaiknya backend punya endpoint /admin/jadwal-dokter/{staffId}
        // Tapi kita pakai cara cepat: Ambil list lalu cari.
        $responseJadwal = Http::withToken($token)
            ->get(env('API_URL') . '/admin/jadwal-dokter', [
                'clinic_id' => $clinicId,
                'staff' => $staff,
            ]);

        $allSchedules = $responseJadwal->successful() ? $responseJadwal->json()['data'] : [];

        // Cari data dokter yang mau diedit
        $targetSchedule = collect($allSchedules)->firstWhere('staff_id', $staffId);

        if (!$targetSchedule) {
            return back()->with('error', 'Data jadwal tidak ditemukan.');
        }

        // Siapkan data agar mudah dibaca di View
        // $targetSchedule['details'] isinya array per hari
        $currentSchedule = $targetSchedule['details'] ?? [];
        $dokterName = $targetSchedule['dokter'];

        return view('admin.jadwal_dokter.edit', compact('staffId', 'currentSchedule', 'dokterName'));
    }

    // --- PROSES SIMPAN (STORE) ---
    public function store(Request $request)
    {
        $token = session('api_token');

        $payload = [
            'staff_id' => $request->staff_id,
            'jadwal' => $request->jadwal,
        ];

        $response = Http::withToken($token)
            ->post(env('API_URL') . '/admin/jadwal-dokter/store', $payload);

        if ($response->successful()) {
            return redirect()->route('admin.jadwal-dokter.index')->with('success', 'Jadwal baru berhasil ditambahkan!');
        }

        if ($response->status() == 422) {
            $pesan = $response->json()['message'] ?? 'Validasi gagal.';
            return back()->with('error', 'Gagal: ' . $pesan)->withInput();
        }

        return back()->with('error', 'Terjadi kesalahan pada server backend.')->withInput();
    }

    // --- PROSES UPDATE ---
    public function update(Request $request, $staffId)
    {
        $token = session('api_token');

        $payload = [
            'jadwal' => $request->jadwal,
        ];

        $response = Http::withToken($token)
            ->put(env('API_URL') . '/admin/jadwal-dokter/update/' . $staffId, $payload);

        if ($response->successful()) {
            return redirect()->route('admin.jadwal-dokter.index')->with('success', 'Jadwal berhasil diperbarui!');
        }

        return back()->with('error', 'Gagal update: ' . ($response->json()['message'] ?? 'Error server'));
    }
}
