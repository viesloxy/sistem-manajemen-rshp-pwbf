<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardPerawatController extends Controller
{
    public function index()
    {
        // Pastikan Anda membuat folder 'perawat' di 'resources/views/'
        return view('perawat.dashboard-perawat');
    }
}