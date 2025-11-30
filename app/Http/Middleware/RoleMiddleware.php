<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $userData = session('user_data');
        if (
            !session()->has('api_token') ||
            !$userData ||
            !in_array($userData['role'] ?? null, $roles)
        ) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // Untuk web, 404 oke jika kamu mau menyembunyikan rute.
            // Tapi 403 lebih jujur. Pilihan di tanganmu.
            abort(404);
        }
        return $next($request);
    }
}
