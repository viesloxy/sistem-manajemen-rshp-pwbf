<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.home');
    }

    public function struktur()
    {
        return view('site.struktur');
    }

    public function layanan()
    {
        return view('site.layanan');
    }

    public function visimisi()
    {
        return view('site.visimisi');
    }

    public function login()
    {
        return view('site.login');
    }

    public function cekKoneksi()
    {
        try {
            \DB::connection()->getPdo();
            return 'Koneksi ke database berhasil!';
        } catch (\Exception $e) {
            return 'Koneksi ke database gagal: ' . $e->getMessage();
        }
    }
}