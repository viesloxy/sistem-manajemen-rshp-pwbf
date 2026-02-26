<?php

namespace App\Http\Controllers\Resepsionis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RegistrasiPetController extends Controller
{
    public function index()
    {
        $pets = DB::table('pet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select(
                'pet.*', 
                'user.nama as nama_pemilik', 
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->orderBy('pet.idpet', 'desc')
            ->get();

        // Perbaikan path view: resepsionis.pet.index
        return view('resepsionis.pet.index', compact('pets'));
    }

    public function create()
    {
        $pemiliks = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.idpemilik', 'user.nama')
            ->orderBy('user.nama')
            ->get();

        $rasHewan = DB::table('ras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select('ras_hewan.idras_hewan', 'ras_hewan.nama_ras', 'jenis_hewan.nama_jenis_hewan')
            ->orderBy('jenis_hewan.nama_jenis_hewan')
            ->get();

        return view('resepsionis.pet.create', compact('pemiliks', 'rasHewan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'idpemilik'     => 'required|exists:pemilik,idpemilik',
            'idras_hewan'   => 'required|exists:ras_hewan,idras_hewan',
            'jenis_kelamin' => 'required|in:J,B', 
            'tanggal_lahir' => 'nullable|date',
            'warna_tanda'   => 'nullable|string|max:45',
        ]);

        try {
            DB::table('pet')->insert([
                'nama'          => $request->nama,
                'idpemilik'     => $request->idpemilik,
                'idras_hewan'   => $request->idras_hewan,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'warna_tanda'   => $request->warna_tanda,
            ]);

            return redirect()->route('resepsionis.pet.index')->with('success', 'Data Pet berhasil ditambahkan.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $pet = DB::table('pet')->where('idpet', $id)->first();
        if (!$pet) return back()->with('error', 'Data tidak ditemukan');

        $pemiliks = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.idpemilik', 'user.nama')
            ->get();

        $rasHewan = DB::table('ras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select('ras_hewan.idras_hewan', 'ras_hewan.nama_ras', 'jenis_hewan.nama_jenis_hewan')
            ->get();

        return view('resepsionis.pet.edit', compact('pet', 'pemiliks', 'rasHewan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'          => 'required|string',
            'idpemilik'     => 'required|exists:pemilik,idpemilik',
            'idras_hewan'   => 'required|exists:ras_hewan,idras_hewan',
            'jenis_kelamin' => 'required|in:J,B',
        ]);

        try {
            DB::table('pet')->where('idpet', $id)->update([
                'nama'          => $request->nama,
                'idpemilik'     => $request->idpemilik,
                'idras_hewan'   => $request->idras_hewan,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'warna_tanda'   => $request->warna_tanda,
            ]);

            return redirect()->route('resepsionis.pet.index')->with('success', 'Data Pet diperbarui.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function showDeleteConfirmation($id)
    {
        $pet = DB::table('pet')
            ->join('pemilik', 'pet.idpemilik', '=', 'pemilik.idpemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->join('ras_hewan', 'pet.idras_hewan', '=', 'ras_hewan.idras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->where('pet.idpet', $id)
            ->select(
                'pet.*', 
                'user.nama as nama_pemilik', 
                'ras_hewan.nama_ras',
                'jenis_hewan.nama_jenis_hewan'
            )
            ->first();

        if (!$pet) {
            return redirect()->route('resepsionis.pet.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('resepsionis.pet.delete', compact('pet'));
    }

    public function destroy($id)
    {
        $exists = DB::table('temu_dokter')->where('idpet', $id)->exists();
        if ($exists) {
            return redirect()->route('resepsionis.pet.index')
                ->with('error', 'Pet tidak bisa dihapus karena ada riwayat kunjungan/medis.');
        }

        try {
            DB::table('pet')->where('idpet', $id)->delete();
            return redirect()->route('resepsionis.pet.index')->with('success', 'Data Pet berhasil dihapus.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}