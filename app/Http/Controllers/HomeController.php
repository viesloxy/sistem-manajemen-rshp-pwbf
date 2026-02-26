<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// --- TAMBAHAN UNTUK REDIRECT OTOMATIS ---
use Illuminate\Support\Facades\Auth;
// --- AKHIR TAMBAHAN ---

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // ==========================================================
        // == PERBAIKAN: Buat Rute /home menjadi "Pintar" ==
        // ==========================================================
        
        // 1. Ambil role ID dari session yang disimpan saat login
        $userRole = session('user_role');

        // 2. Gunakan logic switch yang SAMA seperti di LoginController
        //    untuk mengarahkan user ke dashboard yang benar SETIAP KALI
        //    mereka menekan link "Home".
        
        switch ($userRole) {
            case '1': // 1 = Administrator
                return redirect()->route('admin.dashboard');
                // break; // tidak perlu break setelah return

            case '2': // 2 = Dokter
                return redirect()->route('dokter.dashboard');

            case '3': // 3 = Perawat
                return redirect()->route('perawat.dashboard');

            case '4': // 4 = Resepsionis
                return redirect()->route('resepsionis.dashboard');
            
            default:
                // Default ke dashboard pemilik
                return redirect()->route('pemilik.dashboard');
        }
        
        // Baris di bawah ini (view 'home') tidak akan pernah dieksekusi lagi
        // karena user akan selalu diarahkan ke dashboard spesifik mereka.
        // return view('home');
    }
}