<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PembayaranAdminController extends Controller
{
    public function index()
    {
        $token = session('api_token');

        // DEBUGGING: Cek apakah URL API sudah benar
        // dd(env('API_URL')); 

        $response = Http::withToken($token)
            ->get(env('API_URL') . '/api/kasir/antrian', [
                'status_filter' => 'menunggu_pembayaran'
            ]);

        // DEBUGGING: Tampilkan error jika request gagal
        if ($response->failed()) {
            dd([
                'Status' => $response->status(),
                'Error Body' => $response->body(),
                'URL yang ditembak' => env('API_URL') . '/api/kasir/antrian'
            ]);
        }

        $antrian = $response->successful() ? $response->json()['data'] : [];

        return view('staff.kasir.index', compact('antrian'));
    }

    /*Menangani proses pembayaran dari Kasir*/
    public function store(Request $request, $id) // $id diambil dari route {id}
    {
        $request->validate([
            'total_biaya' => 'required|numeric',
            'metode' => 'required|in:cash,qris,transfer',
        ]);

        $token = session('api_token');

        // Ambil ID Staff yg login (Kasir)
        $staffId = session('user_data')['staff']['id'] ?? null;
        if (!$staffId) {
            return back()->with('error', 'Sesi login tidak valid. ID Staff tidak ditemukan.');
        }

        // PERUBAHAN 1: Endpoint & Payload
        $response = Http::withToken($token)
            ->post(env('API_URL') . '/pembayaran/store', [ // <--- Endpoint khusus pembayaran
                'id_kunjungan' => $id,                 // <--- ID dari URL
                'id_staff' => $staffId,            // <--- ID Kasir yg login
                'total_biaya' => $request->total_biaya, // <--- Dari Input Hidden Form
                'metode_bayar' => $request->metode,      // <--- Dari Dropdown Form
            ]);

        // PERUBAHAN 2: Respon Sukses
        if ($response->successful()) {
            return back()->with('success', 'Pembayaran berhasil disimpan!');
        }

        // Error Handling (Sama persis polanya)
        if ($response->status() == 422) {
            // Validasi gagal di backend
            return back()->with('error', 'Data tidak valid: ' . json_encode($response->json()));
        }

        return back()->with('error', 'Terjadi kesalahan pada server pembayaran.');
    }
}
