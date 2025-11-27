<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
        // 1. Tembak API Login di Backend
        $response = Http::post(env('API_URL') . '/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $token = $data['access_token'];

            session(['api_token' => $token]);
            session(['user_data' => $data['user']]);

            // Regenerate session ID biar aman (standar Laravel)
            $request->session()->regenerate();

            return redirect()->intended(route('beranda', absolute: false));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah (Cek Backend).',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $token = session('api_token');
        if ($token) {
            Http::withToken($token)->post(env('API_URL') . '/logout');
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->forget(['api_token', 'user_data']);

        return redirect('/');
    }
}
