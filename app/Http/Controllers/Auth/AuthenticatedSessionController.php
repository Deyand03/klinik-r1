<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // WAJIB IMPORT INI
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Tembak API Login di Backend (BaaS)
        // Pastikan port 8000 (Backend) menyala
        try {
            $response = Http::post('http://127.0.0.1:8000/api/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal terhubung ke server Backend.']);
        }

        // 2. Cek Apakah Login Berhasil?
        if ($response->successful()) {
            $data = $response->json();

            // 3. Simpan Token & Data User ke Session Browser
            // Ini pengganti Auth::login()
            session([
                'api_token' => $data['access_token'],
                'user_data' => $data['user'], // Berisi data user + profil (staff/pasien)
            ]);

            // Regenerate session ID untuk keamanan
            $request->session()->regenerate();

            // 4. Redirect Sesuai Role
            $role = $data['user']['role'] ?? 'pasien';

            if ($role === 'staff') {
                // Kalau Staff -> Masuk ke Dashboard Staff
                return redirect()->route('staff.dashboard');
            } else {
                // Kalau Pasien -> Masuk ke Beranda
                return redirect()->route('beranda');
            }
        }

        // 5. Jika Gagal (Password Salah / User Tidak Ada)
        return back()->withErrors([
            'email' => $response->json()['message'] ?? 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout dari API Backend juga (Opsional, tapi bagus)
        $token = session('api_token');
        if ($token) {
            Http::withToken($token)->post('http://127.0.0.1:8000/api/logout');
        }

        // Hapus Session Lokal
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
