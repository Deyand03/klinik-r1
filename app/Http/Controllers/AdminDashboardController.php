<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminDashboardController extends Controller
{
    // HALAMAN 1: DASHBOARD (PASIEN)
    public function index(Request $request = null)
    {
        return $this->fetchData($request, 'patients', 'admin.dashboard.index');
    }

    // HALAMAN 2: RIWAYAT KUNJUNGAN
    public function riwayat(Request $request = null)
    {
        return $this->fetchData($request, 'antrian', 'admin.dashboard.riwayat');
    }

    // LOGIKA UTAMA
    private function fetchData($request, $type, $view)
    {
        $request = $request ?: request();
        $token = session('api_token');

        // Ambil semua parameter filter
        $bulanChart = $request->input('month', date('n'));
        $bulanTable = $request->input('month_table');
        $searchKeyword = $request->input('search');
        $klinikId = $request->input('klinik_id'); 
        $dokterId = $request->input('dokter_id'); 
        $page = $request->input('page', 1);

        $response = Http::withToken($token)->get(
            'http://127.0.0.1:8000/api/admin/antrian',
            [
                'type'        => $type,
                'search'      => $searchKeyword,
                'month'       => $bulanChart,
                'month_table' => $bulanTable,
                'klinik_id'   => $klinikId,
                'dokter_id'   => $dokterId,
                'page'        => $page
            ]
        );

        $reservationsPaginator = new LengthAwarePaginator([], 0, 10, 1);
        $chartSource = [];
        $filterOptions = ['clinics' => [], 'doctors' => []]; 
        $totalAllTime = 0;
        $chartLabels = ['Data Kosong']; $chartValues = [1]; $chartColors = ['#e5e7eb'];

        if ($response->successful()) {
            $json = $response->json();
            $tableJson = $json['table']; 
            
            if (isset($json['options'])) {
                $filterOptions = $json['options'];
            }

            // MAPPING DATA
            $mappedItems = collect($tableJson['data'])->map(function ($item) use ($type) {
                if ($type == 'patients') {
                    // Mapping Pasien
                    return [
                        'id' => $item['id'],
                        'initial' => substr($item['nama_lengkap'] ?? 'X', 0, 2),
                        'color' => 'bg-emerald-100 text-emerald-600',
                        'name' => $item['nama_lengkap'] ?? 'Tanpa Nama',
                        'nik' => $item['nik'] ?? '-',
                        'contact' => $item['no_hp'] ?? '-',
                        'address' => $item['alamat_domisili'] ?? '-',
                        'registered_at' => $item['created_at'],
                    ];
                } else {
                    // Mapping Kunjungan
                    return [
                        'id' => $item['id'],
                        'initial' => substr($item['pasien']['nama_lengkap'] ?? 'X', 0, 2),
                        'color' => 'bg-blue-100 text-blue-600',
                        'name' => $item['pasien']['nama_lengkap'] ?? 'Tanpa Nama',
                        'no_antrian' => $item['no_antrian'],
                        'status' => $item['status'],
                        'klinik' => $item['klinik']['nama'] ?? '-',
                        
                        // --- FIX DI SINI TRAINER! ---
                        // Backend kirim objek Staff, kolomnya 'nama_lengkap', bukan 'nama'.
                        'dokter' => $item['dokter']['nama_lengkap'] ?? 'Belum dipilih', 
                        // ----------------------------

                        'contact' => $item['pasien']['no_hp'] ?? '-',
                        'address' => $item['pasien']['alamat_domisili'] ?? '-',
                        'registered_at' => $item['tgl_kunjungan'] ?? $item['created_at'],
                    ];
                }
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
                'month' => $bulanChart,
                'month_table' => $bulanTable,
                'klinik_id' => $klinikId,
                'dokter_id' => $dokterId
            ]);

            // Chart Data
            $chartSource = $json['chart_source'];
            $totalAllTime = $json['meta']['total_all_time'];

            $colorMap = ['Klinik X Subhan' => '#1e1b4b', 'Klinik Mata Sehat'=> '#4338ca', 'Poli Gigi'=> '#0d9488', 'Poli Umum'=> '#f59e0b'];
            $fallbackColors = ['#ef4444', '#14b8a6', '#ccfbf1', '#64748b'];
            $grouped = collect($chartSource)->groupBy('klinik.nama');
            
            $chartLabels = []; $chartValues = []; $chartColors = []; $index = 0;
            foreach ($grouped as $klinikName => $group) {
                $label = $klinikName ?: 'Lainnya'; 
                $chartLabels[] = $label;
                $chartValues[] = $group->count();
                $chartColors[] = isset($colorMap[$label]) ? $colorMap[$label] : $fallbackColors[$index++ % 4];
            }
            if (empty($chartValues)) { $chartLabels = ['Data Kosong']; $chartValues = [1]; $chartColors = ['#e5e7eb']; }
        }

        $data = [
            'profile' => ['name' => session('user_data')['staff']['nama_lengkap'] ?? 'Admin'],
            'stats' => [
                'registered_patients' => $totalAllTime, 
                'new_patients' => count($chartSource), 
            ],
            'chart_pie' => [
                'labels' => $chartLabels, 'values' => $chartValues, 'colors' => $chartColors
            ],
            'table_data' => $reservationsPaginator,
            'options' => $filterOptions, 
            'filters' => [
                'month' => $bulanChart,
                'month_table' => $bulanTable,
                'klinik_id' => $klinikId,
                'dokter_id' => $dokterId,
                'search' => $searchKeyword
            ]
        ];
        
        return view($view, compact('data'));
    }
}