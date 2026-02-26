<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 'required email' -> 'required|email'
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // menggunakan relasi 'roleUser' hasMany)
        $user = User::with(['roleUser' => function($query) {
            $query->where('status', 1); // Hanya ambil role yang statusnya aktif (1)
        }, 'roleUser.role'])
            ->where('email', $request->input('email'))
            ->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'Email tidak ditemukan.'])
                ->withInput();
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Password salah.'])
                ->withInput();
        }

        // Cek jika user ada tapi tidak punya role aktif
if ($user->roleUser->isEmpty()) {
    return redirect()->back()
        ->withErrors(['email' => 'Akun belum memiliki role. Hubungi admin.'])
        ->withInput();
}

        // Ambil nama role
        $namaRole = $user->roleUser[0]->role; 

        // Login user ke session
        Auth::login($user);

        // Simpan session user
        $request->session()->put([
            'user_id' => $user->iduser,
            'user_name' => $user->nama, // Sesuai DB 'rshp'
            'user_email' => $user->email,
            'user_role' => $user->roleUser[0]->idrole ?? 'user',
            'user_role_name' => $namaRole->nama_role ?? 'User',
            'user_status' => $user->roleUser[0]->status ?? 'active'
        ]);
        
        $userRole = $user->roleUser[0]->idrole ?? null;

        switch ($userRole) {
            case '1': // 1 = Administrator
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
            
            case '2': // 2 = Dokter
                return redirect()->route('dokter.dashboard')->with('success', 'Login berhasil!');
            
            case '3': // 3 = Perawat
                return redirect()->route('perawat.dashboard')->with('success', 'Login berhasil!');
            // --- AKHIR PERUBAHAN ---

            case '4': // 4 = Resepsionis
                return redirect()->route('resepsionis.dashboard')->with('success', 'Login berhasil!');
            
            case '5': // 5 = Pemilik
                return redirect()->route('pemilik.dashboard')->with('success', 'Login berhasil!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout berhasil!');
    }
}