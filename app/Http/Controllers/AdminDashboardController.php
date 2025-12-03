<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $token = session('api_token');

        // 1. Ambil Data Antrian Hari Ini dari Backend
        $response = Http::withToken($token)->get('http://127.0.0.1:8000/api/admin/antrian');


        // --- TAMBAHKAN BARIS INI ---
        // Kita cek apa jawaban asli dari Backend
        if ($response->successful()) {
            // dd($response->json()); // <--- UNCOMMENT INI, SAVE, LALU REFRESH HALAMAN
        } else {
            dd("Gagal ambil data:", $response->body());
        }
        // ---------------------------

        $antrian = [];
        if ($response->successful()) {
            $antrian = $response->json()['data'];
        }

        // 2. Siapkan Data untuk View (Sesuaikan format dengan View kamu)
        // Kita mapping data dari API ke format yang dipakai di Blade
        $reservations = collect($antrian)->map(function ($item) {
            return [
                'id' => $item['id'],
                'initial' => substr($item['pasien']['nama_lengkap'], 0, 2), // Ambil inisial
                'color' => 'bg-blue-100 text-blue-600', // Warna avatar random/static
                'name' => $item['pasien']['nama_lengkap'],
                'email' => $item['no_antrian'], // Kita ganti email jadi No Antrian biar berguna
                'contact' => $item['pasien']['no_hp'] ?? '-',
                'address' => $item['pasien']['alamat_domisili'] ?? '-',
                'status' => $item['status'], // Status asli dari DB (booking, menunggu_perawat, dll)
            ];
        });

        // Data dummy untuk chart/statistik (Biarkan dulu biar gak error)
        $data = [
            'profile' => ['name' => session('user_data')['staff']['nama_lengkap'] ?? 'Admin', 'email' => 'Staff'],
            'stats' => ['registered_patients' => count($antrian), 'new_patients' => 5], // Hitung dari data asli
            'chart_line' => [10, 20, 15, 30, 25, 40, 35, 50, 45, 60, 55, 70],
            'reservations' => $reservations // <--- INI DATA PENTINGNYA
        ];

        return view('admin.dashboard.index', compact('data'));
    }

    // Fungsi untuk Tombol Aksi (Check-In / Next Status)
    public function confirm(Request $request, $id)
    {
        $token = session('api_token');

        // Kirim request update status ke Backend
        Http::withToken($token)->post("http://127.0.0.1:8000/api/admin/antrian/{$id}/status", [
            'status' => $request->next_status
        ]);

        return back()->with('success', 'Status pasien berhasil diperbarui!');
    }
}
