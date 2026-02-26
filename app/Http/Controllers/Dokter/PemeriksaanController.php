<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PemeriksaanController extends Controller
{
    // List Pasien untuk Dokter yang Login
    public function index()
    {
        // 1. Ambil ID Role User dokter yang sedang login
        // Asumsi: Auth::user()->iduser digunakan untuk cari idrole_user di tabel role_user
        $userId = Auth::user()->iduser ?? session('user_id'); // Sesuaikan dengan sistem login Anda
        
        $dokter = DB::table('role_user')
            ->where('iduser', $userId)
            ->where('idrole', 2) // Role Dokter
            ->first();

        if(!$dokter) abort(403, 'Akses ditolak. Anda bukan dokter.');

        // 2. Ambil Rekam Medis yang ditugaskan ke dokter ini
        // Status 0 = Belum Diperiksa (Tapi sudah di-asesmen perawat), Status 1 = Selesai
        $pasien = DB::table('rekam_medis as rm')
            ->select(
                'rm.idrekam_medis', 'rm.created_at', 'rm.anamnesa',
                'p.nama as nama_pet', 'u.nama as nama_pemilik',
                'td.status as status_periksa', 'td.no_urut'
            )
            ->join('temu_dokter as td', 'rm.idreservasi_dokter', '=', 'td.idreservasi_dokter')
            ->join('pet as p', 'td.idpet', '=', 'p.idpet')
            ->join('pemilik as pem', 'p.idpemilik', '=', 'pem.idpemilik')
            ->join('user as u', 'pem.iduser', '=', 'u.iduser')
            ->where('rm.dokter_pemeriksa', $dokter->idrole_user) // Filter by Dokter Login
            ->whereDate('rm.created_at', date('Y-m-d')) // Hari ini
            ->orderBy('td.status', 'asc') // Yang belum selesai di atas
            ->orderBy('td.no_urut', 'asc')
            ->get();

        return view('dokter.pemeriksaan.index', compact('pasien'));
    }

    // Halaman Kerja Dokter (Detail RM + Input Tindakan)
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

        // List Tindakan yang sudah diinput
        $tindakan = DB::table('detail_rekam_medis as drm')
            ->join('kode_tindakan_terapi as ktt', 'drm.idkode_tindakan_terapi', '=', 'ktt.idkode_tindakan_terapi')
            ->where('drm.idrekam_medis', $id)
            ->select('drm.*', 'ktt.deskripsi_tindakan_terapi', 'ktt.kode')
            ->get();

        // Master Data Tindakan untuk Dropdown
        $masterTindakan = DB::table('kode_tindakan_terapi')->orderBy('kode')->get();

        return view('dokter.pemeriksaan.edit', compact('header', 'tindakan', 'masterTindakan'));
    }

    // Update Diagnosa Akhir
    public function updateDiagnosa(Request $request, $id)
    {
        DB::table('rekam_medis')->where('idrekam_medis', $id)->update([
            'diagnosa' => $request->diagnosa,
            'temuan_klinis' => $request->temuan_klinis, // Dokter boleh revisi temuan klinis perawat
        ]);
        return back()->with('success', 'Diagnosa disimpan.');
    }

    // Tambah Tindakan (Detail)
    public function storeTindakan(Request $request, $id)
    {
        $request->validate([
            'idkode_tindakan_terapi' => 'required',
        ]);

        DB::table('detail_rekam_medis')->insert([
            'idrekam_medis' => $id,
            'idkode_tindakan_terapi' => $request->idkode_tindakan_terapi,
            'detail' => $request->detail, // Catatan tambahan misal: Dosis obat
        ]);

        return back()->with('success', 'Tindakan ditambahkan.');
    }

    // Hapus Tindakan
    public function destroyTindakan($idDetail)
    {
        DB::table('detail_rekam_medis')->where('iddetail_rekam_medis', $idDetail)->delete();
        return back()->with('success', 'Tindakan dihapus.');
    }

    // Selesai Pemeriksaan (Finalisasi)
    public function markAsDone($id)
    {
        // 1. Pastikan diagnosa sudah diisi
        $rm = DB::table('rekam_medis')->where('idrekam_medis', $id)->first();
        if(empty($rm->diagnosa)) {
            return back()->with('error', 'Diagnosa harus diisi sebelum menyelesaikan pemeriksaan.');
        }

        // 2. Update status temu_dokter jadi 1 (Selesai)
        DB::table('temu_dokter')->where('idreservasi_dokter', $rm->idreservasi_dokter)->update(['status' => '1']);

        return redirect()->route('dokter.pemeriksaan.index')->with('success', 'Pemeriksaan Selesai. Pasien dipulangkan.');
    }
}