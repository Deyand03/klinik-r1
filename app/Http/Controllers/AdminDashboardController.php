<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminDashboardController extends Controller
{
    public function index()
    {

    //     $token = session('api_token');

    //     // Pastikan URL API benar (tanpa /api jika di env sudah ada, atau sesuaikan)
    //     // Default: http://127.0.0.1:8000/api/admin/dashboard
    //     $apiUrl = env('API_URL') . '/admin/dashboard';

    //     $response = Http::withToken($token)->get($apiUrl);

    //     // Jika token expired atau API mati
    //     if ($response->failed()) {
    //         return redirect()->route('login')->with('error', 'Gagal mengambil data dashboard. Silakan login ulang.');
    //     }

    //     $data = $response->json();

    //     // Oper data ke View
    //     return view('admin.dashboard.index', compact('data'));
    // }

    // // Fungsi Konfirmasi (Update Status)
    // public function confirm(Request $request, $id)
    // {
    //     $token = session('api_token');
    //     $nextStatus = $request->input('next_status'); // 'Diperiksa' atau 'Selesai'

    //     $apiUrl = env('API_URL') . "/admin/kunjungan/{$id}/update-status";

    //     $response = Http::withToken($token)->post($apiUrl, [
    //         'status' => $nextStatus
    //     ]);

    //     if ($response->successful()) {
    //         return back()->with('success', "Status pasien berhasil diubah menjadi $nextStatus.");
    //     } else {
    //         return back()->with('error', 'Gagal mengubah status.');
    //     }
    // }
   $data = [
            'profile' => [
                'name'  => 'Dr. Budi Santoso', // Nanti di-explode di blade
                'email' => 'dokter@klinik.com'
            ],
            'stats' => [
                'registered_patients' => 1250,
                'new_patients' => 45,
            ],
            // Data untuk Line Chart (12 Bulan)
            'chart_line' => [
                1500000, 2300000, 1800000, 3200000, 2100000, 
                2800000, 3500000, 2900000, 3800000, 4200000, 
                3100000, 4500000
            ],
            // Data untuk Tabel Reservasi
            'reservations' => [
                [
                    'id' => 1,
                    'initial' => 'A',
                    'color' => 'bg-purple-100 text-purple-700',
                    'name' => 'Anita Tumblr',
                    'email' => 'anita@gmail.com',
                    'contact' => '081234567890',
                    'address' => 'Lrg. Obat Nyamuk',
                    'status' => 'Booking' // Ubah ini untuk tes tombol 'Diperiksa'
                ],
                [
                    'id' => 2,
                    'initial' => 'T',
                    'color' => 'bg-blue-100 text-blue-700',
                    'name' => 'Trainee SM ent.',
                    'email' => 'trainee@gmail.com',
                    'contact' => '081234567891',
                    'address' => 'Jl. Gangnam',
                    'status' => 'Diperiksa' // Ubah ini untuk tes tombol 'Selesai'
                ],
                [
                    'id' => 3,
                    'initial' => 'W',
                    'color' => 'bg-green-100 text-green-700',
                    'name' => 'Wowok Basudara',
                    'email' => 'wowok@gmail.com',
                    'contact' => '081234567892',
                    'address' => 'Jl. Simulator',
                    'status' => 'Selesai' // Tombol akan hilang (strip)
                ],
                [
                    'id' => 4,
                    'initial' => 'S',
                    'color' => 'bg-yellow-100 text-yellow-700',
                    'name' => 'Sucipto',
                    'email' => 'cipto@gmail.com',
                    'contact' => '081234567893',
                    'address' => 'Lrg. Gunung Salak',
                    'status' => 'Booking'
                ],
                [
                    'id' => 5,
                    'initial' => 'F',
                    'color' => 'bg-red-100 text-red-700',
                    'name' => 'Fufufafa',
                    'email' => 'fufu@gmail.com',
                    'contact' => '081234567894',
                    'address' => 'Jl. Dua Tiga',
                    'status' => 'Booking'
                ],
            ]
        ];

        return view('admin.dashboard.index', compact('data'));
    }

    // Fungsi Dummy untuk menangani klik tombol (Biar tidak error 404/500)
    public function confirm(Request $request, $id)
    {
        $statusBaru = $request->input('next_status');
        
        // Karena ini dummy, kita cuma kasih notifikasi pura-pura sukses
        return back()->with('success', "Berhasil mengubah status menjadi: $statusBaru (Mode Dummy)");
    }
}
