<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Sesuai modul

class isAdministrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Jika user tidak terautentikasi, redirect ke login
        if (!Auth::check()) { // Perbaikan dari modul (logika dibalik)
            return redirect()->route("login");
        }

        // 2. Ambil role dari session
        $userRole = session('user_role');

        // 3. Jika user terautentikasi tapi role BUKAN 1 (Administrator), tolak
        if ($userRole == 1) { // 1 = Administrator
            return $next($request); // Lanjutkan
        } else {
            // Kembali ke halaman sebelumnya dengan error
            return back()->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini');
        }
    }
}