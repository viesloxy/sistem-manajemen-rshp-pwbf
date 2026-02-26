<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class RegistrasiPemilikController extends Controller
{
    public function index()
    {
        $pemiliks = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.*', 'user.nama', 'user.email')
            ->orderBy('pemilik.idpemilik', 'desc')
            ->get();

        // Perbaikan path view: resepsionis.pemilik.index
        return view('resepsionis.pemilik.index', compact('pemiliks'));
    }

    public function create()
    {
        return view('resepsionis.pemilik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:user,email',
            'password' => 'required|min:6',
            'alamat'   => 'required|string|max:255',
            'no_wa'    => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            // 1. Insert User
            $userId = DB::table('user')->insertGetId([
                'nama'     => $request->nama,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 2. Insert Pemilik
            DB::table('pemilik')->insert([
                'iduser' => $userId,
                'alamat' => $request->alamat,
                'no_wa'  => $request->no_wa,
            ]);

            DB::table('role_user')->insert([
            'iduser' => $userId,
            'idrole' => 5, // PEMILIK
            'status' => 1
            ]);

            DB::commit();

            return redirect()->route('resepsionis.pemilik.index')
                ->with('success', 'Data Pemilik berhasil ditambahkan.');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
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
            return redirect()->route('resepsionis.pemilik.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('resepsionis.pemilik.edit', compact('pemilik'));
    }

    public function update(Request $request, $id)
    {
        $pemilik = DB::table('pemilik')->where('idpemilik', $id)->first();
        if (!$pemilik) return back()->with('error', 'Data tidak ditemukan');

        $request->validate([
            'nama'   => 'required|string|max:100',
            'email'  => 'required|email|unique:user,email,'.$pemilik->iduser.',iduser',
            'alamat' => 'required|string',
            'no_wa'  => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            // Update User
            DB::table('user')->where('iduser', $pemilik->iduser)->update([
                'nama'  => $request->nama,
                'email' => $request->email,
            ]);

            // Update Pemilik
            DB::table('pemilik')->where('idpemilik', $id)->update([
                'alamat' => $request->alamat,
                'no_wa'  => $request->no_wa,
            ]);

            DB::commit();
            return redirect()->route('resepsionis.pemilik.index')->with('success', 'Data Pemilik diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function showDeleteConfirmation($id)
    {
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->where('pemilik.idpemilik', $id)
            ->select('pemilik.*', 'user.nama', 'user.email')
            ->first();

        if (!$pemilik) {
            return redirect()->route('resepsionis.pemilik.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('resepsionis.pemilik.delete', compact('pemilik'));
    }

    public function destroy($id)
    {
        // Cek Pet
        $hasPet = DB::table('pet')->where('idpemilik', $id)->exists();
        if ($hasPet) {
            return redirect()->route('resepsionis.pemilik.index')
                ->with('error', 'Gagal hapus: Pemilik masih memiliki data hewan registered.');
        }

        $pemilik = DB::table('pemilik')->where('idpemilik', $id)->first();
        
        DB::beginTransaction();
        try {
            DB::table('pemilik')->where('idpemilik', $id)->delete();
            // Hapus user loginnya juga
            if($pemilik) {
                DB::table('user')->where('iduser', $pemilik->iduser)->delete();
            }
            DB::commit();
            return redirect()->route('resepsionis.pemilik.index')->with('success', 'Data Pemilik berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}