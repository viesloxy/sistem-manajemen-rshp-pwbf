<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class DashboardAdminController extends Controller
{

    public function index()
    {
        // Langsung tampilkan view
        // Data (nama, email, role) akan diambil dari session di dalam view
        return view('admin.dashboard-admin');
    }
}