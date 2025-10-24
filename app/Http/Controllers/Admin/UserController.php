<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
        public function index()
    {
        // 2. Ambil semua data dari model User
        $users = User::all();
        
        // 3. Kirim data ke view 'admin.user.index'
        // Anda perlu membuat folder 'user' di 'resources/views/admin/'
        return view('admin.user.index', compact('users'));
    }
}
