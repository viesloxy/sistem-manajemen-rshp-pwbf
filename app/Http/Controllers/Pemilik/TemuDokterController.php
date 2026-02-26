<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TemuDokterController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->iduser ?? session('user_id');
        
        // Cari ID Pemilik
        $roleUser = DB::table('role_user')
            ->where('iduser', $userId)
            ->where('idrole', 5) // 5 = Pemilik
            ->where('status', 1)
            ->first();

        if (!$roleUser) {
            return redirect()->route('home')->with('error', 'Data pemilik tidak ditemukan');
        }

        $pemilikId = $roleUser->idrole_user;

        // List Hewan untuk Dropdown Modal
        $pets = DB::table('pet')
            ->where('idpemilik', $pemilikId)
            ->orderBy('nama', 'asc')
            ->get();

        // List Temu Dokter (History & Active)
        $temuDokterList = DB::table('temu_dokter as td')
            ->select(
                'td.idreservasi_dokter',
                'td.no_urut',
                'td.waktu_daftar',
                'td.status',
                'td.idpet',
                'p.nama as nama_pet',
                'jh.nama_jenis_hewan',
                'rh.nama_ras',
                'u_dokter.nama as nama_dokter'
            )
            ->join('pet as p', 'td.idpet', '=', 'p.idpet')
            ->leftJoin('ras_hewan as rh', 'p.idras_hewan', '=', 'rh.idras_hewan')
            ->leftJoin('jenis_hewan as jh', 'rh.idjenis_hewan', '=', 'jh.idjenis_hewan')
            ->leftJoin('rekam_medis as rm', 'td.idreservasi_dokter', '=', 'rm.idreservasi_dokter')
            ->leftJoin('role_user as ru', 'rm.dokter_pemeriksa', '=', 'ru.idrole_user')
            ->leftJoin('user as u_dokter', 'ru.iduser', '=', 'u_dokter.iduser')
            ->where('p.idpemilik', $pemilikId)
            ->orderBy('td.waktu_daftar', 'desc')
            ->get();

        return view('pemilik.temu-dokter.index', compact('pets', 'temuDokterList'));
    }

    public function store(Request $request)
    {
        $userId = Auth::user()->iduser ?? session('user_id');
        
        $roleUser = DB::table('role_user')
            ->where('iduser', $userId)
            ->where('idrole', 5)
            ->first();

        if (!$roleUser) {
            return redirect()->route('home')->with('error', 'Data pemilik tidak ditemukan');
        }

        $pemilikId = $roleUser->idrole_user;

        $request->validate([
            'idpet' => 'required|exists:pet,idpet',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
        ], [
            'tanggal_kunjungan.after_or_equal' => 'Tanggal kunjungan tidak boleh di masa lalu.'
        ]);

        try {
            // Verifikasi kepemilikan pet
            $pet = DB::table('pet')
                ->where('idpet', $request->idpet)
                ->where('idpemilik', $pemilikId)
                ->first();

            if (!$pet) {
                return redirect()->back()->with('error', 'Pet tidak valid.');
            }

            // Generate nomor urut
            $tanggal = date('Y-m-d', strtotime($request->tanggal_kunjungan));
            $lastNo = DB::table('temu_dokter')
                ->whereDate('waktu_daftar', $tanggal)
                ->max('no_urut');
            $noUrut = $lastNo ? $lastNo + 1 : 1;

            // Simpan Temu Dokter
            DB::table('temu_dokter')->insert([
                'no_urut' => $noUrut,
                'waktu_daftar' => $request->tanggal_kunjungan . ' ' . now()->format('H:i:s'), // Default jam sekarang
                'status' => '0', // Menunggu
                'idpet' => $request->idpet,
                'idrole_user' => $roleUser->idrole_user, // ID Pemilik (role_user)
            ]);

            return redirect()->route('pemilik.temu-dokter.list')
                ->with('success', 'Jadwal temu dokter berhasil dibuat. No Antrian: ' . $noUrut);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function cancel($id)
    {
        $td = DB::table('temu_dokter')->where('idreservasi_dokter', $id)->first();

        if (!$td) return back()->with('error', 'Data tidak ditemukan.');
        if ($td->status != '0') {
            return back()->with('error', 'Hanya jadwal dengan status "Menunggu" yang bisa dibatalkan.');
        }

        // Update status menjadi '2' (Batal) atau hapus data jika kebijakan klinik memperbolehkan
        // Disini kita update status saja agar history tetap ada
        DB::table('temu_dokter')->where('idreservasi_dokter', $id)->update(['status' => '2']);

        return back()->with('success', 'Jadwal temu dokter dibatalkan.');
    }
}