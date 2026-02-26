<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class PemilikController extends Controller
{

    public function index()
    {
        $pemiliks = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.*', 'user.nama', 'user.email')
            ->orderBy('pemilik.idpemilik', 'desc')
            ->get();

        return view('admin.pemilik.index', compact('pemiliks'));
    }

    public function create()
    {
        $users = DB::table('user')
            ->whereNotIn('iduser', function ($query) {
                $query->select('iduser')->from('pemilik');
            })
            ->get();

        return view('admin.pemilik.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required',
            'email'    => 'required|email|unique:user,email',
            'password' => 'required|min:6',
            'alamat'   => 'required',
            'no_wa'    => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            // 1. Insert user
            $userId = DB::table('user')->insertGetId([
                'nama'     => $request->nama,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 2. Insert pemilik
            DB::table('pemilik')->insert([
                'iduser' => $userId,
                'alamat' => $request->alamat,
                'no_wa'  => $request->no_wa,
            ]);

            // 3. Assign role PEMILIK
            DB::table('role_user')->insert([
                'iduser' => $userId,
                'idrole' => 5, // PEMILIK
                'status' => 1
            ]);

            DB::commit();
            return redirect()->route('admin.pemilik.index')
                ->with('success', 'Pemilik berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->where('pemilik.idpemilik', $id)
            ->select('pemilik.*', 'user.nama', 'user.email')
            ->first();

        if (!$pemilik) {
            return redirect()->route('admin.pemilik.index')
                ->with('error', 'Data pemilik tidak ditemukan');
        }

        $users = DB::table('user')->get();

        return view('admin.pemilik.edit', compact('pemilik', 'users'));
    }

    public function update(Request $request, $id)
    {
        $pemilik = DB::table('pemilik')->where('idpemilik', $id)->first();

        if (!$pemilik) {
            return back()->with('error', 'Data pemilik tidak ditemukan');
        }

        DB::table('user')->where('iduser', $pemilik->iduser)->update([
            'nama'  => $request->nama,
            'email' => $request->email,
        ]);

        DB::table('pemilik')->where('idpemilik', $id)->update([
            'alamat' => $request->alamat,
            'no_wa'  => $request->no_wa,
        ]);

        return redirect()->route('admin.pemilik.index')
            ->with('success', 'Pemilik berhasil diperbarui');
    }

    public function showDeleteConfirmation($id)
    {
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->where('pemilik.idpemilik', $id)
            ->select('pemilik.*', 'user.nama', 'user.email')
            ->first();

        if (!$pemilik) {
            return redirect()->route('admin.pemilik.index')
                ->with('error', 'Data pemilik tidak ditemukan');
        }

        return view('admin.pemilik.delete', compact('pemilik'));
    }

    public function destroy($id)
    {
        $pemilik = DB::table('pemilik')->where('idpemilik', $id)->first();

        if ($pemilik) {
            DB::table('pemilik')->where('idpemilik', $id)->delete();
            DB::table('user')->where('iduser', $pemilik->iduser)->delete();
        }

        return redirect()->route('admin.pemilik.index')
            ->with('success', 'Pemilik berhasil dihapus');
    }
}
