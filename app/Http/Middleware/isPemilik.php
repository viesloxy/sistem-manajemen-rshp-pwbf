<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class isPemilik
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Harus login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Harus role Pemilik
        $userRole = session('user_role');

        // 3. Jika BUKAN pemilik LOGOUT
        if ($userRole != 5) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Akses khusus Pemilik.']);
        }

        // 3. Ambil ID Pemilik dari tabel pemilik
        $userId = Auth::user()->iduser ?? session('user_id');

        $idPemilik = DB::table('pemilik')
            ->where('iduser', $userId)
            ->value('idpemilik');


        // 4. Inject ke request (GLOBAL untuk semua controller pemilik)
        $request->attributes->set('idPemilik', $idPemilik);

        return $next($request);
    }
}
