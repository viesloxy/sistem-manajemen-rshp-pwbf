<?php

namespace App\Http\Controllers\Perawat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class RekamMedisController extends Controller
{
    // INDEX - List Reservasi & Rekam Medis
    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal');
        $bulan = $request->get('bulan', date('Y-m'));

        // Query Antrian (Belum ada RM)
        $antrianQuery = DB::table('temu_dokter as td')
            ->select('td.*', 'p.nama as nama_pet', 'u.nama as nama_pemilik', 'd_u.nama as nama_dokter')
            ->join('pet as p', 'td.idpet', '=', 'p.idpet')
            ->join('pemilik as pem', 'p.idpemilik', '=', 'pem.idpemilik')
            ->join('user as u', 'pem.iduser', '=', 'u.iduser')
            ->leftJoin('role_user as ru', 'td.idrole_user', '=', 'ru.idrole_user')
            ->leftJoin('user as d_u', 'ru.iduser', '=', 'd_u.iduser')
            ->leftJoin('rekam_medis as rm', 'td.idreservasi_dokter', '=', 'rm.idreservasi_dokter')
            ->where('td.status', '0')
            ->whereNull('rm.idrekam_medis')
            ->orderBy('td.no_urut');

        // Query History (Sudah ada RM) - JOIN DIPERBAIKI
        $historyQuery = DB::table('rekam_medis as rm')
            ->select('rm.*', 'p.nama as nama_pet', 'u.nama as nama_pemilik', 'td.status as status_kunjungan')
            ->join('temu_dokter as td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter') // Join ke temu_dokter dulu
            ->join('pet as p', 'td.idpet', '=', 'p.idpet') // Baru ke pet
            ->join('pemilik as pem', 'p.idpemilik', '=', 'pem.idpemilik')
            ->join('user as u', 'pem.iduser', '=', 'u.iduser')
            ->orderBy('rm.created_at', 'desc');

        // Filter
        if ($tanggal) {
            $antrianQuery->whereDate('td.waktu_daftar', $tanggal);
            $historyQuery->whereDate('rm.created_at', $tanggal);
        } else {
            $antrianQuery->whereDate('td.waktu_daftar', date('Y-m-d'));
            $historyQuery->where(DB::raw("DATE_FORMAT(rm.created_at, '%Y-%m')"), $bulan);
        }

        $antrian = $antrianQuery->get();
        $history = $historyQuery->get();

        return view('perawat.rekam-medis.index', compact('antrian', 'history', 'tanggal', 'bulan'));
    }

    public function create($idReservasi, $idPet)
    {
        $info = DB::table('temu_dokter as td')
            ->select('td.*', 'p.nama as nama_pet', 'u.nama as nama_pemilik', 'td.idrole_user as id_dokter_tujuan')
            ->join('pet as p', 'td.idpet', '=', 'p.idpet')
            ->join('pemilik as pem', 'p.idpemilik', '=', 'pem.idpemilik')
            ->join('user as u', 'pem.iduser', '=', 'u.iduser')
            ->where('td.idreservasi_dokter', $idReservasi)
            ->first();

        $dokters = DB::table('role_user as ru')
            ->join('user as u', 'ru.iduser', '=', 'u.iduser')
            ->where('ru.idrole', 2)
            ->select('ru.idrole_user', 'u.nama')
            ->get();

        return view('perawat.rekam-medis.create', compact('info', 'dokters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'idreservasi' => 'required',
            'dokter_pemeriksa' => 'required',
            'anamnesa' => 'required|string',
            'temuan_klinis' => 'required|string',
        ]);

        try {
            $id = DB::table('rekam_medis')->insertGetId([
                'idreservasi_dokter' => $request->idreservasi,
                'dokter_pemeriksa' => $request->dokter_pemeriksa,
                'anamnesa' => $request->anamnesa,
                'temuan_klinis' => $request->temuan_klinis,
                'created_at' => now(),
            ]);

            return redirect()->route('perawat.rekam-medis.show', $id)->with('success', 'Asesmen awal disimpan.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $header = DB::table('rekam_medis as rm')
            ->select('rm.*', 'p.nama as nama_pet', 'u.nama as nama_pemilik', 'd_u.nama as nama_dokter')
            ->join('temu_dokter as td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
            ->join('pet as p', 'td.idpet', '=', 'p.idpet')
            ->join('pemilik as pem', 'p.idpemilik', '=', 'pem.idpemilik')
            ->join('user as u', 'pem.iduser', '=', 'u.iduser')
            ->leftJoin('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->leftJoin('user as d_u', 'ru.iduser', '=', 'd_u.iduser')
            ->where('rm.idrekam_medis', $id)
            ->first();

        $tindakan = DB::table('detail_rekam_medis as drm')
            ->join('kode_tindakan_terapi as ktt', 'drm.idkode_tindakan_terapi', '=', 'ktt.idkode_tindakan_terapi')
            ->where('drm.idrekam_medis', $id)
            ->get();

        return view('perawat.rekam-medis.show', compact('header', 'tindakan'));
    }

    public function edit($id)
    {
        $rm = DB::table('rekam_medis as rm')
            ->select('rm.*', 'p.nama as nama_pet', 'u.nama as nama_pemilik')
            ->join('temu_dokter as td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
            ->join('pet as p', 'td.idpet', '=', 'p.idpet')
            ->join('pemilik as pem', 'p.idpemilik', '=', 'pem.idpemilik')
            ->join('user as u', 'pem.iduser', '=', 'u.iduser')
            ->where('rm.idrekam_medis', $id)
            ->first();

        if (!$rm) return redirect()->route('perawat.rekam-medis.index')->with('error', 'Data tidak ditemukan.');

        $status = DB::table('temu_dokter')->where('idreservasi_dokter', $rm->idreservasi_dokter)->value('status');
        if ($status == '1') {
            return redirect()->route('perawat.rekam-medis.show', $id)
                ->with('error', 'Pemeriksaan sudah selesai, tidak dapat diedit.');
        }

        return view('perawat.rekam-medis.edit', compact('rm'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'anamnesa' => 'required',
            'temuan_klinis' => 'required',
        ]);

        DB::table('rekam_medis')->where('idrekam_medis', $id)->update([
            'anamnesa' => $request->anamnesa,
            'temuan_klinis' => $request->temuan_klinis,
        ]);

        return redirect()->route('perawat.rekam-medis.show', $id)->with('success', 'Data diperbarui.');
    }

    // KONFIRMASI DELETE - FIX QUERY DI SINI
    public function showDeleteConfirmation($id)
    {
        $rm = DB::table('rekam_medis as rm')
            ->select('rm.idrekam_medis', 'rm.created_at', 'p.nama as nama_pet', 'u.nama as nama_pemilik')
            // PERBAIKAN: Join lewat temu_dokter dulu
            ->join('temu_dokter as td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
            ->join('pet as p', 'td.idpet', '=', 'p.idpet') // Baru join ke pet
            ->join('pemilik as pem', 'p.idpemilik', '=', 'pem.idpemilik')
            ->join('user as u', 'pem.iduser', '=', 'u.iduser')
            ->where('rm.idrekam_medis', $id)
            ->first();

        if (!$rm) return back()->with('error', 'Data tidak ditemukan.');

        return view('perawat.rekam-medis.delete', compact('rm'));
    }

    // DESTROY - Hapus Permanen
    public function destroy($id)
    {
        $hasTindakan = DB::table('detail_rekam_medis')->where('idrekam_medis', $id)->exists();
        if ($hasTindakan) {
            return redirect()->route('perawat.rekam-medis.index')
                ->with('error', 'Gagal hapus. Dokter sudah mengisi tindakan/obat pada rekam medis ini.');
        }

        DB::table('rekam_medis')->where('idrekam_medis', $id)->delete();
        return redirect()->route('perawat.rekam-medis.index')->with('success', 'Rekam medis berhasil dihapus.');
    }
}