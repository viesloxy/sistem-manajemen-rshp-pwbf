<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isDokter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Jika user tidak terautentikasi, redirect ke login
        if (!Auth::check()) {
            return redirect()->route("login");
        }

        // 2. Ambil role dari session
        $userRole = session('user_role');

        // 3. Jika user terautentikasi tapi role BUKAN 2 (Dokter), tolak
        //    (Berdasarkan DB Anda, 2 = Dokter)
        if ($userRole == 2) { // 2 = Dokter
            return $next($request); // Lanjutkan
        } else {
            // Kembali ke halaman sebelumnya dengan error
            return back()->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini');
        }
    }
}