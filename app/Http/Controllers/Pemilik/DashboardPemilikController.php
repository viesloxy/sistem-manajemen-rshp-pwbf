<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardPemilikController extends Controller
{
public function index(Request $request)
{
    $idPemilik = $request->attributes->get('idPemilik');

    if (!$idPemilik) {
        // Tetap tampilkan dashboard kosong
        return view('pemilik.dashboard-pemilik', [
            'totalPet' => 0,
            'reservasiAktif' => 0,
            'lastVisitDate' => '-',
            'totalRekamMedis' => 0,
            'pets' => collect()
        ]);
    }

    $totalPet = DB::table('pet')->where('idpemilik', $idPemilik)->count();

    $reservasiAktif = DB::table('temu_dokter as td')
        ->join('pet as p', 'td.idpet', '=', 'p.idpet')
        ->where('p.idpemilik', $idPemilik)
        ->where('td.status', '0')
        ->count();

    $lastVisit = DB::table('temu_dokter as td')
        ->join('pet as p', 'td.idpet', '=', 'p.idpet')
        ->where('p.idpemilik', $idPemilik)
        ->where('td.status', '1')
        ->orderBy('td.waktu_daftar', 'desc')
        ->first();

    $lastVisitDate = $lastVisit
        ? \Carbon\Carbon::parse($lastVisit->waktu_daftar)->format('d M Y')
        : '-';

    $totalRekamMedis = DB::table('rekam_medis as rm')
        ->join('temu_dokter as td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
        ->join('pet as p', 'td.idpet', '=', 'p.idpet')
        ->where('p.idpemilik', $idPemilik)
        ->count();

    $pets = DB::table('pet')
        ->where('idpemilik', $idPemilik)
        ->limit(5)
        ->get();

    return view('pemilik.dashboard-pemilik', compact(
        'totalPet',
        'reservasiAktif',
        'lastVisitDate',
        'totalRekamMedis',
        'pets'
    ));
}
}