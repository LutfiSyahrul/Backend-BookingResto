<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek apakah user sudah login DAN memiliki role yang sesuai permintaan
        if ($request->user() && $request->user()->role === $role) {
            return $next($request); // Silakan masuk bos!
        }

        // Jika rolenya tidak cocok (misal customer mencoba masuk ke adminresto)
        return response()->json([
            'success' => false,
            'message' => 'Akses ditolak! Halaman ini khusus untuk ' . $role
        ], 403); // 403 Forbidden
    }
}
