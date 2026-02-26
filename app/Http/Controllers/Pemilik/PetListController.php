<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PetListController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->iduser;
        
        // Ambil ID Pemilik
        $idPemilik = DB::table('pemilik')->where('iduser', $userId)->value('idpemilik');

        $pets = DB::table('pet as p')
            ->select(
                'p.*', 
                'rh.nama_ras', 
                'jh.nama_jenis_hewan'
            )
            ->leftJoin('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->leftJoin('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->where('p.idpemilik', $idPemilik)
            ->get();

        return view('pemilik.pet.index', compact('pets'));
    }

    public function show($id)
    {
        $userId = Auth::user()->iduser;
        $idPemilik = DB::table('pemilik')->where('iduser', $userId)->value('idpemilik');

        // Detail Pet
        $pet = DB::table('pet as p')
            ->select('p.*', 'rh.nama_ras', 'jh.nama_jenis_hewan')
            ->leftJoin('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->leftJoin('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->where('p.idpet', $id)
            ->where('p.idpemilik', $idPemilik) // Security check: Pastikan milik sendiri
            ->first();

        if(!$pet) abort(404);

        // Riwayat Medis Pet Ini
        $riwayat = DB::table('rekam_medis as rm')
            ->select('rm.*', 'td.waktu_daftar', 'd_u.nama as nama_dokter')
            ->join('temu_dokter as td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
            ->leftJoin('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->leftJoin('user as d_u', 'ru.iduser', '=', 'd_u.iduser')
            ->where('td.idpet', $id) // Filter by Pet ID via Temu Dokter
            ->orderBy('rm.created_at', 'desc')
            ->get();

        return view('pemilik.pet.show', compact('pet', 'riwayat'));
    }
}