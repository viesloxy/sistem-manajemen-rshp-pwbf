<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class RoleController extends Controller
{
    public function index()
    {
        // Ambil SEMUA user, dan load relasi 'roles' mereka
        // Ini sama seperti: $pemilik = Pemilik::with('user')->get();
        // Kita juga memuat relasi 'roles.pivot' untuk status
        $users = User::with('roles')->get();
        
        // Kirim data 'users' (bukan 'roles') ke view
        return view('admin.role.index', compact('users'));
    }
}
