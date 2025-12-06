<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RiwayatReservasiController extends Controller
{
    public function index()
    {
        $token = session('api_token');

        $riwayat = [];

        if ($token) {
            try {
                // Ensure the port matches your backend (usually 8000)
                $response = Http::withToken($token)->get('http://127.0.0.1:8000/api/pasien/riwayat');

                if ($response->successful()) {
                    $riwayat = $response->json()['data'];
                }
            } catch (\Exception $e) {
                // Handle connection error if backend is down
                $riwayat = [];
            }
        }

        return view('pasien.riwayat_reservasi.index', compact('riwayat'));
    }
}
