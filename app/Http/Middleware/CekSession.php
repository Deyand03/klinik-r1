<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekSession
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah ada token API di session?
        if (!session()->has('api_token')) {
            // Kalau gak ada, redirect ke login dengan pesan error
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}