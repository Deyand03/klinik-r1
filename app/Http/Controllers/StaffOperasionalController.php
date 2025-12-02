<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StaffOperasionalController extends Controller
{
    // FUNGSI UTAMA: Ambil data dengan filter spesifik
    private function getDataAntrian($status)
    {
        $token = session('api_token');

        // BEST PRACTICE: Tempel parameter langsung di URL Query String
        // Hasil: http://.../api/admin/antrian?status_filter=booking
        $url = 'http://127.0.0.1:8000/api/admin/antrian?status_filter=' . $status;

        $response = Http::withToken($token)->get($url);

        return $response->successful() ? $response->json()['data'] : [];
    }

    // 1. HALAMAN RESEPSIONIS (Hanya lihat 'booking')
    public function indexResepsionis()
    {
        $antrian = $this->getDataAntrian('booking');
        return view('staff.resepsionis.index', compact('antrian'));
    }

    // 2. HALAMAN PERAWAT (Hanya lihat 'menunggu_perawat')
    public function indexPerawat()
    {
        $antrian = $this->getDataAntrian('menunggu_perawat');
        return view('staff.perawat.index', compact('antrian'));
    }

    // 3. HALAMAN DOKTER
    public function indexDokter()
    {
        $antrian = $this->getDataAntrian('menunggu_dokter');
        return view('staff.dokter.index', compact('antrian'));
    }

    // 4. HALAMAN KASIR
    public function indexKasir()
    {
        $antrian = $this->getDataAntrian('menunggu_pembayaran');
        return view('staff.kasir.index', compact('antrian'));
    }
}
