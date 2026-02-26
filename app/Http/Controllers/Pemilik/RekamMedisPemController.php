<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekamMedisPemController extends Controller
{
    /**
     * LIST RIWAYAT REKAM MEDIS PEMILIK
     */
    public function index(Request $request)
    {
        // idPemilik dari middleware isPemilik
        $idPemilik = $request->attributes->get('idPemilik');

        if (!$idPemilik) {
            return redirect()->route('pemilik.dashboard')
                ->with('error', 'Data pemilik tidak ditemukan.');
        }

        $rekamMedis = DB::table('rekam_medis as rm')
            ->select(
                'rm.idrekam_medis',
                'rm.created_at',
                'rm.diagnosa',
                'p.nama as nama_pet',
                'u.nama as nama_dokter'
            )
            ->join('temu_dokter as td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
            ->join('pet as p', 'td.idpet', '=', 'p.idpet')
            ->leftJoin('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->leftJoin('user as u', 'ru.iduser', '=', 'u.iduser')
            ->where('p.idpemilik', $idPemilik)
            ->orderBy('rm.created_at', 'desc')
            ->get();

        return view('pemilik.rekam-medis.index', compact('rekamMedis'));
    }

    /**
     * DETAIL REKAM MEDIS (READ ONLY)
     */
    public function show(Request $request, $id)
    {
        $idPemilik = $request->attributes->get('idPemilik');

        $header = DB::table('rekam_medis as rm')
            ->select(
                'rm.*',
                'p.nama as nama_pet',
                'u.nama as nama_dokter'
            )
            ->join('temu_dokter as td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
            ->join('pet as p', 'td.idpet', '=', 'p.idpet')
            ->leftJoin('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->leftJoin('user as u', 'ru.iduser', '=', 'u.iduser')
            ->where('rm.idrekam_medis', $id)
            ->where('p.idpemilik', $idPemilik) // SECURITY
            ->first();

        if (!$header) {
            return redirect()->route('pemilik.rekammedis.list')
                ->with('error', 'Data rekam medis tidak ditemukan.');
        }

        $tindakan = DB::table('detail_rekam_medis as drm')
            ->join(
                'kode_tindakan_terapi as ktt',
                'drm.idkode_tindakan_terapi',
                '=',
                'ktt.idkode_tindakan_terapi'
            )
            ->select(
                'ktt.kode',
                'ktt.deskripsi_tindakan_terapi',
                'drm.detail'
            )
            ->where('drm.idrekam_medis', $id)
            ->get();

        return view('pemilik.rekam-medis.show', compact('header', 'tindakan'));
    }
}
