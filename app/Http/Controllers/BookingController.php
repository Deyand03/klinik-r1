<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // 1. Ambil Token
        $token = session('api_token');

        // 2. Tembak API Backend
        $response = Http::withToken($token)->post(env('API_URL') .'booking', [
            'id_dokter' => $request->id_dokter,
            'id_jadwal' => 1,
            'tgl_kunjungan' => date('Y-m-d'), // Hari ini
            'keluhan' => $request->keluhan,
        ]);

        // 3. Cek Hasil
        if ($response->successful()) {
            // SUKSES -> Tampilkan Tiket
            $tiket = $response->json()['data'];
            return view('pasien.cari_dokter.tiket_antrian', compact('tiket'));
        } else {
            // GAGAL -> Balikin ke form + Pesan Error
            // Ambil pesan error dari JSON backend
            $pesan = $response->json()['message'] ?? 'Gagal memproses booking';

            return back()->with('error', $pesan);
        }
    }
}
