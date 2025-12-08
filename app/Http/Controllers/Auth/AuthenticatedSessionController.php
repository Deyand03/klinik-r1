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
        try {
            // 1. Tambahkan Header 'Accept: application/json'
            // Ini HUKUM WAJIB antar Laravel biar backend gak nge-redirect kalau error
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->post(env('API_URL') . '/login', [ // rtrim jaga-jaga kalau ada double slash
                        'email' => $request->email,
                        'password' => $request->password,
                    ]);

        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Koneksi ke server Backend terputus: ' . $e->getMessage()]);
        }

        // 3. Cek Login
        if ($response->successful()) {
            $data = $response->json();

            // Validasi struktur JSON sebelum akses
            if (!isset($data['access_token'])) {
                return back()->withErrors(['email' => 'Respon server tidak valid (Token hilang).']);
            }

            session([
                'api_token' => $data['access_token'],
                'user_data' => $data['user'] ?? [],
            ]);

            $request->session()->regenerate();

            $role = $data['user']['role'] ?? 'pasien';

            return redirect()->route($role === 'staff' ? 'staff.dashboard' : 'beranda');
        }

        // 4. Handle Error (401, 422, dll)
        // Ambil pesan error dari JSON backend, kalau null default ke string
        $errorMessage = $response->json()['message'] ?? 'Login gagal. Cek kredensial Anda.';

        return back()->withErrors([
            'email' => $errorMessage,
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
            Http::withToken($token)->post(env('API_URL') . '/logout');
        }

        // Hapus Session Lokal
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
