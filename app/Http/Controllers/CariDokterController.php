<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CariDokterController extends Controller
{
    // Halaman Pencarian
    public function index(Request $request)
    {
        // 1. Ambil Data Klinik (Dropdown)
        $clinics = Http::get(env('API_URL') . '/public/clinics')->json()['data'] ?? [];

        // 2. Ambil Data Dokter (Filter jika ada input klinik)
        $url = env('API_URL') . '/public/doctors';
        if ($request->has('klinik') && $request->klinik != 'Semua Klinik') {
            $url .= '?klinik_id=' . $request->klinik;
        }

        $doctors = Http::get($url)->json()['data'] ?? [];

        return view('pasien.cari_dokter.index', compact('doctors', 'clinics'));
    }

    // Halaman Profil Dokter
    public function show($id)
    {
        // Ambil detail dokter by ID
        $response = Http::get(env('API_URL') . "/public/doctors/{$id}");

        if ($response->failed()) {
            return redirect()->route('cari_dokter')->with('error', 'Dokter tidak ditemukan.');
        }

        $doctor = $response->json()['data'];
        return view('pasien.cari_dokter.profil_dokter', compact('doctor'));
    }
}
