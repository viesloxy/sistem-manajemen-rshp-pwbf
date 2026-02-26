<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class TemuDokterController extends Controller
{
    public function index()
    {
        $antrians = DB::table('temu_dokter')
            ->join('pet', 'temu_dokter.idpet', '=', 'pet.idpet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user as u_pemilik', 'pemilik.iduser', '=', 'u_pemilik.iduser')
            ->join('role_user', 'temu_dokter.idrole_user', '=', 'role_user.idrole_user')
            ->join('user as u_dokter', 'role_user.iduser', '=', 'u_dokter.iduser')
            ->leftJoin('dokter', 'u_dokter.iduser', '=', 'dokter.id_user')
            ->select(
                'temu_dokter.*',
                'pet.nama as nama_pet',
                'u_pemilik.nama as nama_pemilik',
                'u_dokter.nama as nama_dokter',
                'dokter.bidang_dokter'
            )
            ->orderBy('temu_dokter.waktu_daftar', 'desc')
            ->get();

        return view('resepsionis.temu-dokter.index', compact('antrians'));
    }

    public function create()
    {
        $pets = DB::table('pet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pet.idpet', 'pet.nama as nama_pet', 'user.nama as nama_pemilik')
            ->orderBy('pet.nama')
            ->get();

        $dokters = DB::table('role_user')
            ->join('user', 'role_user.iduser', '=', 'user.iduser')
            ->leftJoin('dokter', 'user.iduser', '=', 'dokter.id_user')
            ->where('role_user.idrole', 2) 
            ->select(
                'role_user.idrole_user', 
                'user.nama', 
                'dokter.bidang_dokter'
            )
            ->get();

        return view('resepsionis.temu-dokter.create', compact('pets', 'dokters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pendaftaran' => 'required|date', // Validasi Tanggal
            'idpet'               => 'required|exists:pet,idpet',
            'idrole_user'         => 'required|exists:role_user,idrole_user',
        ]);

        try {
            // Ambil tanggal yang dipilih resepsionis
            $tanggalInput = $request->tanggal_pendaftaran;
            
            // Gabungkan tanggal input + jam sekarang (agar format timestamp valid)
            // Ini akan disimpan ke kolom 'waktu_daftar' di database
            $waktuDaftar = $tanggalInput . ' ' . now()->format('H:i:s');

            // Generate No Urut berdasarkan Tanggal yang DIPILIH (Reset per tanggal)
            $lastAntrian = DB::table('temu_dokter')
                ->whereDate('waktu_daftar', $tanggalInput)
                ->orderBy('no_urut', 'desc')
                ->first();

            $no_urut = $lastAntrian ? $lastAntrian->no_urut + 1 : 1;

            DB::table('temu_dokter')->insert([
                'no_urut'      => $no_urut,
                'waktu_daftar' => $waktuDaftar, // Simpan tanggal pilihan
                'status'       => '0', // 0 = Menunggu
                'idpet'        => $request->idpet,
                'idrole_user'  => $request->idrole_user,
            ]);

            return redirect()->route('resepsionis.temu-dokter.index')
                ->with('success', 'Antrian berhasil dibuat untuk tanggal '. Carbon::parse($tanggalInput)->format('d-m-Y') . '. Nomor Urut: ' . $no_urut);

        } catch (Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }
}