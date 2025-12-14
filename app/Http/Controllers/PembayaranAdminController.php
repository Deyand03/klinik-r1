<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PembayaranAdminController extends Controller
{
    public function index()
{
    $token = session('api_token');
    $apiUrl = env('API_URL'); // Ambil URL

    // ---------------------------------------------------------
    // TAHAP 1: CEK URL (Matikan dd ini jika URL sudah benar)
    // ---------------------------------------------------------
    // dd('Cek URL saat ini:', $apiUrl); 
    // ^^^ Hapus tanda // di depan dd kalau mau cek URL dulu

    $response = Http::withToken($token)
        ->get($apiUrl . '/api/kasir/antrian', [
            'status_filter' => 'menunggu_pembayaran' 
        ]);

    // ---------------------------------------------------------
    // TAHAP 2: CEK ERROR (JIKA GAGAL)
    // ---------------------------------------------------------
    if ($response->failed()) {
        dd([
            'STATUS' => 'GAGAL / ERROR',
            'Kode HTTP' => $response->status(), // 401, 404, 500?
            'Pesan Error' => $response->body(),
            'URL yang ditembak' => $apiUrl . '/api/kasir/antrian'
        ]);
    }

    // ---------------------------------------------------------
    // TAHAP 3: CEK DATA (JIKA SUKSES TAPI KOSONG)
    // ---------------------------------------------------------
    // Data sukses diambil
    $dataAntrian = $response->json()['data'] ?? [];

    // Tampilkan paksa isinya biar kita tahu kosong atau ada isi
    dd([
        'STATUS' => 'SUKSES (200 OK)',
        'Jumlah Data' => count($dataAntrian),
        'Isi Data' => $dataAntrian,
        'Pesan' => count($dataAntrian) == 0 ? 'DATABASE KOSONG / FILTER TIDAK COCOK' : 'ADA DATA KOK!'
    ]);

    // Kode di bawah ini tidak akan jalan karena kena dd() di atas
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
