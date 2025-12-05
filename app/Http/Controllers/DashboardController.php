<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;




class DashboardController extends Controller
{
    // Helper: Ambil data dari Backend API
    private function getDataAntrian($status)
    {
        $token = session('api_token');
        $url = 'http://127.0.0.1:8000/api/perawat/antrian?status_filter=' . $status; // Gunakan IP 0.0.0.0 untuk host jika port berbeda

        try {
            $response = Http::withToken($token)->get($url);
            return $response->successful() ? $response->json()['data'] : [];
        } catch (\Exception $e) {
            // Log::error('API Error in Dashboard: ' . $e->getMessage());
            return []; // Return kosong jika API mati
        }
    }


    // =========================================================
    // I. VIEW REDIRECTER (GET /staff/dashboard)
    // =========================================================

    public function index()
    {
        $role = session('user_data')['staff']['peran'] ?? 'guest';

        switch ($role) {
            case 'resepsionis':
                $request = request();

                $token = session('api_token');
                $user  = session('user_data');

                // Ambil antrian dari API dengan filter
                $response = Http::withToken($token)->get(env('API_URL') . '/admin/antrian', [
                    'staff_id'      => $user['id'],
                    'search'        => $request->input('search'),
                    'status_filter' => 'booking',
                ]);

                if ($response->failed()) {
                    return back()->with('error', 'Gagal mengambil data antrian');
                }

                $antrian = $response->json()['data'] ?? [];
                

                return view('staff.resepsionis.index', compact('antrian'));

            case 'perawat':
                $antrian = $this->getDataAntrian('menunggu_perawat');
                return view('staff.perawat.index', compact('antrian'));


            case 'dokter':
                $antrian = $this->getDataAntrian('menunggu_dokter');
                return view('staff.dokter.index', compact('antrian'));

            case 'kasir':
                $antrian = $this->getDataAntrian('menunggu_pembayaran');
                return view('staff.kasir.index', compact('antrian'));

            case 'admin':
                return app(AdminDashboardController::class)->index();

            default:
                return abort(403, 'Role tidak dikenali atau Anda bukan Staff.');
        }
    }

    public function store(Request $request)
    {
        return back()->with('success', 'Berhasil disimpan');

        
    }


    // =========================================================
    // II. OPERASIONAL ACTIONS (POST Methods)
    // =========================================================

    // Helper untuk update status di Backend
    private function updateBackendStatus($id, $nextStatus)
    {   
        $api = env('API_URL');
        $token = session('api_token');
        return Http::withToken($token)->post("$api/admin/antrian/{$id}/status", [
            'status' => $nextStatus
        ]);
        
    }

    // 1. Aksi Resepsionis (Check-In)
    public function checkIn(Request $request, $id)
    {
        $response = $this->updateBackendStatus($id, 'menunggu_perawat');

        if ($response->successful()) {
            return back()->with('success', 'Pasien berhasil Check-In dan diteruskan ke Perawat.');
        }
        return back()->with('error', 'Gagal Check-In: ' . ($response->json()['message'] ?? 'Error API'));
    }

    // 2. Aksi Perawat (Simpan Vital Signs & Anamnesa)
    public function storeVital(Request $request, $id)
    {
        $apiUrl = "http://127.0.0.1:8000/api/perawat/input-vital/" . $id;

        $response = Http::post($apiUrl, [
            'berat_badan' => $request->berat_badan,
            'tensi_darah' => $request->tensi_darah,
            'suhu_badan' => $request->suhu_badan,
            'anamnesa' => $request->anamnesa,
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Berhasil disimpan');
        }

        return redirect()->back()->with('error', 'Gagal menyimpan');
    }



    // 3. Aksi Dokter (Simpan Diagnosa & Resep)
    public function storeDokter(Request $request, $id)
    {
        // Logika untuk menyimpan Rekam Medis & Resep ke API Backend
        // ... Logika yang lebih kompleks dari storePerawat ...

        // Simulasikan update status saja dulu
        $response = $this->updateBackendStatus($id, 'menunggu_pembayaran');

        if ($response->successful()) {
            return back()->with('success', 'Pemeriksaan selesai. Pasien diteruskan ke Kasir.');
        }
        return back()->with('error', 'Gagal menyimpan diagnosa.');
    }

    // 4. Aksi Kasir (Pembayaran Lunas)
    public function storeKasir(Request $request, $id)
    {
        // Simulasikan pembayaran sukses dan update status
        $response = $this->updateBackendStatus($id, 'selesai');

        if ($response->successful()) {
            return back()->with('success', 'Pembayaran berhasil dikonfirmasi. Transaksi Selesai.');
        }
        return back()->with('error', 'Gagal konfirmasi pembayaran.');
    }





}


