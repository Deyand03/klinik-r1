<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $token = session('api_token');

        // Kirim data booking ke Backend
        $response = Http::withToken($token)->post('http://127.0.0.1:8000/api/booking/store', [
            'id_dokter' => $request->id_dokter,
            'keluhan' => $request->keluhan,
            'tanggal' => $request->tanggal, // Input baru yang wajib ada
        ]);

        if ($response->successful()) {
            $tiket = $response->json()['data'];
            // Redirect ke halaman tiket sambil bawa datanya
            return redirect()->route('tiket_antrian')->with('tiket', $tiket);
        }

        return back()->with('error', 'Gagal booking: ' . ($response->json()['message'] ?? 'Terjadi kesalahan'));
    }

    public function showTiket()
    {
        // Ambil data tiket dari session (flash data)
        $tiket = session('tiket');

        if (!$tiket) {
            return redirect()->route('beranda'); // Kalau direfresh hilang, balik ke beranda
        }

        return view('pasien.cari_dokter.tiket_antrian', compact('tiket'));
    }
}
