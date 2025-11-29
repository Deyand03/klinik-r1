<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class JadwalDokterController extends Controller
{

    public function index()
    {
        // 1. Ambil Token & Data User dari Session (Hasil Login)
        $token = session('api_token');
        $user = session('user_data');

        // 2. Ambil ID Klinik Staff
        // (Pastikan saat login, API Backend mengirim data relasi 'staff')
        $clinicId = $user['staff']['id_klinik'] ?? null;
        $staff = $user['staff'] ?? null;
        // 3. Tembak API Backend: Ambil Daftar Jadwal
        // URL Backend: /api/admin/schedules (Sesuai standard REST API)
        $responseJadwal = Http::withToken($token)
            ->get(env('API_URL') . '/admin/jadwal-dokter', [
                'clinic_id' => $clinicId,
                'staff' => $staff,
            ]);

        // Kalau sukses ambil datanya, kalau gagal kasih array kosong
        $schedules = $responseJadwal->successful() ? $responseJadwal->json()['data'] : [];

        // 4. Tembak API Backend: Ambil List Dokter (Buat Dropdown Modal Tambah)
        $responseDokter = Http::withToken($token)
            ->get(env('API_URL') . '/admin/jadwal-dokter/list-dokter', [
                'clinic_id' => $clinicId,
                'staff' => $staff,
            ]);

        $doctors = $responseDokter->successful() ? $responseDokter->json()['data'] : [];

        // 5. Lempar ke View dengan data dinamis
        return view('admin.jadwal_dokter.index', compact('schedules', 'doctors'));
    }


    public function edit(Request $request, $id)
    {
        $token = session('api_token');

        // Kirim data update
        $response = Http::withToken($token)
            ->put(env('API_URL') . '/admin/jadwal-dokter/' . $id, [
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'kuota' => $request->kuota,
                'status' => $request->status,
            ]);

        if ($response->successful()) {
            return back()->with('success', 'Jadwal berhasil diperbarui!');
        }

        $errorMessage = $response->json()['message'] ?? 'Terjadi kesalahan server';
        return back()->with('error', 'Gagal update: ' . $errorMessage);
    }

    public function store(Request $request)
    {
        $token = session('api_token');

        $response = Http::withToken($token)
            ->post(env('API_URL') . '/admin/jadwal-dokter/store', [
                'staff_id' => $request->staff_id,
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'kuota' => $request->kuota,
                'status' => $request->status,
            ]);

        // Jika Sukses (201 Created)
        if ($response->successful()) {
            return back()->with('success', 'Jadwal baru berhasil ditambahkan!');
        }

        // Jika Gagal karena Validasi (422) - Contoh: Dokter udah ada
        if ($response->status() == 422) {
            $pesan = $response->json()['message'] ?? 'Data tidak valid.';
            return back()->with('error', 'Gagal: ' . $pesan);
        }

        // Error Lainnya (500)
        return back()->with('error', 'Terjadi kesalahan pada server.');
    }
}
