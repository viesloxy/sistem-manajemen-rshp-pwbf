<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardDokterController extends Controller
{
    public function index()
    {
        // Pastikan Anda membuat folder 'dokter' di 'resources/views/'
        return view('dokter.dashboard-dokter');
    }
}