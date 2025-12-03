<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    // Helper: Ambil data dari Backend API
    private function getDataAntrian($status)
    {
        $token = session('api_token');
        // Backend API (BaaS) - Pastikan URL backend benar
        $url = 'http://127.0.0.1:8000/api/admin/antrian?status_filter=' . $status;

        try {
            $response = Http::withToken($token)->get($url);
            return $response->successful() ? $response->json()['data'] : [];
        } catch (\Exception $e) {
            return []; // Return kosong jika API mati
        }
    }

    public function index()
    {
        // 1. Cek Role dari Session
        $role = session('user_data')['staff']['peran'] ?? 'guest';

        // 2. Arahkan ke View Masing-Masing
        switch ($role) {
            case 'resepsionis':
                // Ambil yang statusnya 'booking'
                $antrian = $this->getDataAntrian('booking');
                return view('staff.resepsionis.index', compact('antrian'));

            case 'perawat':
                // Ambil yang statusnya 'menunggu_perawat'
                $antrian = $this->getDataAntrian('menunggu_perawat');
                return view('staff.perawat.index', compact('antrian'));

            case 'dokter':
                // Ambil yang statusnya 'menunggu_dokter'
                $antrian = $this->getDataAntrian('menunggu_dokter');
                return view('staff.dokter.index', compact('antrian'));

            case 'kasir':
                // Ambil yang statusnya 'menunggu_pembayaran'
                $antrian = $this->getDataAntrian('menunggu_pembayaran');
                return view('staff.kasir.index', compact('antrian'));

            case 'admin':
                // Admin dilempar ke Dashboard Statistik
                return app(AdminDashboardController::class)->index();

            default:
                return abort(403, 'Role tidak dikenali atau Anda bukan Staff.');
        }
    }
}
