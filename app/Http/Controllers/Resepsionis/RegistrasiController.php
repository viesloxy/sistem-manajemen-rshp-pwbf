<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemuDokter; // 1. Import model TemuDokter

class RegistrasiController extends Controller
{
    /**
     * Tampilkan halaman daftar pendaftaran
     */
    public function index()
    {
        // 2. Ambil semua data pendaftaran (temu_dokter)
        $pendaftaran = TemuDokter::with([
                            'pet.pemilik.user', 
                            'dokter.user'
                        ])
                        ->orderBy('waktu_daftar', 'desc') // Tampilkan yang terbaru dulu
                        ->get();

        // 3. Kirim data ke view BARU (sesuai folder 'registrasi' Anda)
        return view('resepsionis.registrasi.index', compact('pendaftaran'));
    }
}