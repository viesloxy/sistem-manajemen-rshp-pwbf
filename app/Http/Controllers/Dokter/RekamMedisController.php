<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RekamMedisController extends Controller
{
    public function index()
    {
        $user = Auth::user(); 
        $userId = $user ? $user->iduser : 6; 

        $dokter = DB::table('role_user')
            ->where('iduser', $userId)
            ->where('idrole', 2)
            ->first();
        
        $query = DB::table('rekam_medis as rm')
            ->select(
                'rm.idrekam_medis', 'rm.created_at', 'rm.anamnesa',
                'p.nama as nama_pet', 'u.nama as nama_pemilik',
                'td.status as status_periksa', 'td.no_urut'
            )
            ->join('temu_dokter as td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
            ->join('pet as p', 'td.idpet', '=', 'p.idpet')
            ->join('pemilik as pem', 'p.idpemilik', '=', 'pem.idpemilik')
            ->join('user as u', 'pem.iduser', '=', 'u.iduser')
            ->whereDate('rm.created_at', date('Y-m-d'))
            ->orderBy('td.status', 'asc')
            ->orderBy('td.no_urut', 'asc');

        if ($dokter) {
            $query->where('rm.dokter_pemeriksa', $dokter->idrole_user);
        }

        $pasien = $query->get();

        return view('dokter.rekam-medis.index', compact('pasien'));
    }

    // Method Edit / Detail
    public function edit($id)
    {
        $header = DB::table('rekam_medis as rm')
            ->select('rm.*', 'p.nama as nama_pet', 'u.nama as nama_pemilik', 'td.status as status_periksa')
            ->join('temu_dokter as td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
            ->join('pet as p', 'td.idpet', '=', 'p.idpet')
            ->join('pemilik as pem', 'p.idpemilik', '=', 'pem.idpemilik')
            ->join('user as u', 'pem.iduser', '=', 'u.iduser')
            ->where('rm.idrekam_medis', $id)
            ->first();

        $tindakan = DB::table('detail_rekam_medis as drm')
            ->join('kode_tindakan_terapi as ktt', 'drm.idkode_tindakan_terapi', '=', 'ktt.idkode_tindakan_terapi')
            ->where('drm.idrekam_medis', $id)
            ->select('drm.*', 'ktt.deskripsi_tindakan_terapi', 'ktt.kode')
            ->get();

        $masterTindakan = DB::table('kode_tindakan_terapi')->orderBy('kode')->get();

        // PERUBAHAN NAMA VIEW DI SINI (Pakai Hyphen - )
        return view('dokter.rekam-medis.detail-rekam-medis', compact('header', 'tindakan', 'masterTindakan'));
    }

    public function updateDiagnosa(Request $request, $id)
    {
        DB::table('rekam_medis')->where('idrekam_medis', $id)->update([
            'diagnosa' => $request->diagnosa,
            'temuan_klinis' => $request->temuan_klinis,
        ]);
        return back()->with('success', 'Data medis disimpan.');
    }

    public function storeTindakan(Request $request, $id)
    {
        $request->validate(['idkode_tindakan_terapi' => 'required']);

        DB::table('detail_rekam_medis')->insert([
            'idrekam_medis' => $id,
            'idkode_tindakan_terapi' => $request->idkode_tindakan_terapi,
            'detail' => $request->detail,
        ]);

        return back()->with('success', 'Tindakan ditambahkan.');
    }

    public function destroyTindakan($idDetail)
    {
        DB::table('detail_rekam_medis')->where('iddetail_rekam_medis', $idDetail)->delete();
        return back()->with('success', 'Tindakan dihapus.');
    }
    
    public function updateTindakan(Request $request, $idDetail)
    {
        DB::table('detail_rekam_medis')->where('iddetail_rekam_medis', $idDetail)->update([
            'detail' => $request->detail
        ]);
        return back()->with('success', 'Detail tindakan diupdate.');
    }

    public function markAsDone($id)
    {
        $rm = DB::table('rekam_medis')->where('idrekam_medis', $id)->first();
        if (empty($rm->diagnosa)) {
            return back()->with('error', 'Diagnosa harus diisi sebelum selesai.');
        }

        DB::table('temu_dokter')->where('idreservasi_dokter', $rm->idreservasi_dokter)->update(['status' => '1']);
        return redirect()->route('dokter.rekam-medis.index')->with('success', 'Pemeriksaan Selesai.');
    }
}