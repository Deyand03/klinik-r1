<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class JadwalDokterController extends Controller
{
    public function index()
    {
        // 1. Ambil Token & Data User dari Session
        $token = session('api_token');
        $user = session('user_data');

        // Ambil ID Klinik dari session staff (biar admin cuma liat jadwal kliniknya sendiri)
        // Pastikan saat Login, data 'staff' ikut disimpan di session 'user'
        $clinicId = $user['staff']['id_klinik'] ?? null;

        // 2. Ambil Data Jadwal dari Backend API
        $responseJadwal = Http::withToken($token)
            ->get(env('API_URL') . '/admin/jadwal-dokter', [
                'clinic_id' => $clinicId
            ]);

        // Kalau sukses ambil datanya, kalau gagal kasih array kosong
        $jadwals = $responseJadwal->successful() ? $responseJadwal->json()['data'] : [];

        $responseDokter = Http::withToken($token)
            ->get(env('API_URL') . '/admin/jadwal-dokter/list-dokter', [
                'clinic_id' => $clinicId
            ]);

        $dokter = $responseDokter->successful() ? $responseDokter->json()['data'] : [];
        // 4. Lempar ke View
        return view('admin.jadwal_dokter.index', compact('jadwals', 'dokter'));
    }

    public function edit(Request $request, $id)
    {
        $token = session('api_token');
        $payload = [
            'status' => $request->status,
            'kuota' => $request->kuota,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'hari' => $request->hari,
        ];
        $response = Http::withToken($token)
            ->put(env('API_URL') . '/admin/jadwal-dokter/' . $id, $payload);

        // 4. Cek Hasil
        if ($response->successful()) {
            return back()->with('success', 'Jadwal dokter berhasil diperbarui!');
        } else {
            // Kalau gagal, balikin pesan error dari API
            return back()->with('error', 'Gagal update: ' . $response->json()['message'] ?? []);
        }
    }

    public function store(Request $request)
    {
        $token = session('api_token');

        // Kirim data inputan modal ke Backend API
        $response = Http::withToken($token)
            ->post(env('API_URL') . '/admin/jadwal-dokter/store', [
                'staff_id' => $request->staff_id,
                'hari' => $request->hari, // Array ['Senin', 'Selasa']
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'kuota' => $request->kuota,
                'status' => $request->status , // 'aktif' / 'nonaktif'
            ]);

        // Cek Respon Backend
        if ($response->successful()) {
            return back()->with('success', 'Jadwal baru berhasil ditambahkan!');
        }

        // Kalau gagal, ambil pesan error dari API
        $errorMessage = $response->json()['message'] ?? 'Terjadi kesalahan server';
        return back()->with('error', 'Gagal menambah jadwal: ' . $errorMessage);
    }
}
