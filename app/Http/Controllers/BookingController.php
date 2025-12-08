<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $token = session('api_token');

        $response = Http::withToken($token)->post('localhost:8000/api/booking/store', [
            'id_dokter' => $request->id_dokter,
            'keluhan'   => $request->keluhan,
            'tanggal'   => $request->tanggal,
        ]);

        if ($response->successful()) {
            $tiket = $response->json()['data'];
            return redirect()->route('tiket_antrian')->with('tiket', $tiket);
        }

        // --- DEBUGGING START ---
        // Jika error validasi (422), ambil pesannya
        if ($response->status() === 422) {
            $msg = $response->json()['message'] ?? 'Validasi gagal';
            return back()->with('error', 'Gagal: ' . $msg);
        }

        // Jika Error Server (500), tampilkan body response-nya biar ketahuan
        // JANGAN DIBIARKAN "Terjadi Kesalahan" SAJA
        return back()->with('error', 'Server Error: ' . $response->body());
        // --- DEBUGGING END ---
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
