<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminDashboardController extends Controller
{
    public function index(Request $request = null)
    {
        $request = $request ?: request();
        $token = session('api_token');

        // Ambil filter dari input user, default bulan sekarang kalau kosong
        $bulanTerpilih = $request->input('month', date('n'));
        $searchKeyword = $request->input('search');
        $page = $request->input('page', 1);
        // 1. Ambil Data Antrian Hari Ini dari Backend
        // Kita kirim parameter search dan month ke API backend (OperasionalController)
        // $request->all() akan mengirim ?search=...&month=...
        $response = Http::withToken($token)->get(
            'http://127.0.0.1:8000/api/admin/antrian',
            [
                'search' => $searchKeyword,
                'month'  => $bulanTerpilih,
                'page'   => $page
            ]
        );

        // --- TAMBAHKAN BARIS INI ---
        // Kita cek apa jawaban asli dari Backend
        if ($response->successful()) {
            //dd($response->json()); // <--- UNCOMMENT INI, SAVE, LALU REFRESH HALAMAN
        } else {
            dd("Gagal ambil data:", $response->body());
        }
        // ---------------------------
        
        $reservationsPaginator = new LengthAwarePaginator([], 0, 10, 1);
        $chartSource = [];
        $totalAllTime = 0;
        if ($response->successful()) {
            $json = $response->json();
            
            // 1. AMBIL DATA TABEL (PAGINATED)
            $tableJson = $json['table']; 
            
            $mappedItems = collect($tableJson['data'])->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'initial' => substr($item['pasien']['nama_lengkap'] ?? 'X', 0, 2),
                    'color' => 'bg-blue-100 text-blue-600',
                    'name' => $item['pasien']['nama_lengkap'] ?? 'Tanpa Nama',
                    'no_antrian' => $item['no_antrian'],
                    'contact' => $item['pasien']['no_hp'] ?? '-',
                    'address' => $item['pasien']['alamat_domisili'] ?? '-',
                    'registered_at' => $item['created_at'],
                    
                ];
            });

            $reservationsPaginator = new LengthAwarePaginator(
                $mappedItems, 
                $tableJson['total'], 
                $tableJson['per_page'], 
                $tableJson['current_page'], 
                ['path' => url()->current()]
            );
            $reservationsPaginator->appends([
                'search' => $searchKeyword,
                'month' => $bulanTerpilih
            ]);

            // 2. AMBIL DATA CHART
            $chartSource = $json['chart_source'];
            $totalAllTime = $json['meta']['total_all_time'];
        }

        // 3. Logika Pie Chart (Sederhana berdasarkan data yg ditarik)
        // Kita hitung jumlah kunjungan per Klinik (Poli) dari data yang didapat
        // Kalau data kosong (karena filter), chart akan kosong/default
        $colorMap = [
            'Klinik X Subhan'  => '#1e1b4b', // Navy Gelap
            'Klinik Mata Sehat'=> '#4338ca', // Ungu/Biru
            'Poli Gigi'        => '#0d9488', // Teal
            'Poli Umum'        => '#f59e0b', // Orange
            // Tambahkan klinik lain di sini...
        ];
        
        // Warna cadangan kalau nama kliniknya gak ada di kamus
        $fallbackColors = ['#ef4444', '#14b8a6', '#ccfbf1', '#64748b'];

        // Kelompokkan data
        $grouped = collect($chartSource)->groupBy('klinik.nama');
        
        $chartLabels = [];
        $chartValues = [];
        $chartColors = [];
        $index = 0;

        foreach ($grouped as $klinikName => $group) {
            // Nama Klinik (Label)
            $label = $klinikName ?: 'Lainnya'; 
            $chartLabels[] = $label;
            
            // Jumlah Pasien (Value)
            $chartValues[] = $group->count();
            
            // Tentukan Warna (Color)
            // Cek kamus dulu, kalau gak ada ambil warna cadangan
            if (isset($colorMap[$label])) {
                $chartColors[] = $colorMap[$label];
            } else {
                // Ambil warna cadangan secara berurutan (modulo) biar gak error
                $chartColors[] = $fallbackColors[$index % count($fallbackColors)];
                $index++;
            }
        }

        // Fallback chart kosong
        if (empty($chartValues)) {
            $chartLabels = ['Tidak ada data'];
            $chartValues = [1];
            $chartColors = ['#e5e7eb']; // Abu-abu
        }

        $data = [
            'profile' => ['name' => session('user_data')['staff']['nama_lengkap'] ?? 'Admin'],
            'stats' => [
                // LOGIKA BARU: 
                // registered_patients = Total Seumur Hidup (dari meta backend)
                'registered_patients' => $totalAllTime, 
                
                // new_patients = Total Bulan Ini (hasil filter count($antrian))
                'new_patients' => count($chartSource), 
            ],
            // Kita kirim data chart lengkap (Label, Value, Warna)
            'chart_pie' => [
                'labels' => $chartLabels,
                'values' => $chartValues,
                'colors' => $chartColors
            ],
            'reservations' => $reservationsPaginator,
            'filters' => [
                'month' => $bulanTerpilih,
                'search' => $searchKeyword
            ]
        ];
        return view('admin.dashboard.index', compact('data'));
    }

    // Fungsi untuk Tombol Aksi (Check-In / Next Status)
    public function confirm(Request $request, $id)
    {
    
    }
}
