<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestOrPasien
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sedang login?
        if (session()->has('api_token') && session()->has('user_data')) {
            
            $role = session('user_data')['role'] ?? 'guest';

            // Jika yang login adalah STAFF, tendang ke Dashboard mereka
            // Karena Staff tidak seharusnya keluyuran di halaman depan/booking
            if ($role === 'staff') {
                return redirect()->route('staff.dashboard');
            }
        }

        // Jika Guest (belum login) ATAU Pasien (role != staff), silakan lewat
        return $next($request);
    }
}