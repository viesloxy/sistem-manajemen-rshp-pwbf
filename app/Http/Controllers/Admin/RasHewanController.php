<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import Facade DB
use Exception;

class RasHewanController extends Controller
{
    public function index()
    {
        $rasHewan = DB::table('ras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select('ras_hewan.*', 'jenis_hewan.nama_jenis_hewan')
            ->get();

        $formattedData = $rasHewan->map(function($item) {
            $item->jenisHewan = (object) ['nama_jenis_hewan' => $item->nama_jenis_hewan];
            return $item;
        });

        return view('admin.ras-hewan.index', ['rasHewan' => $formattedData]);
    }

    public function create()
    {
        $jenisHewans = DB::table('jenis_hewan')->get();
        return view('admin.ras-hewan.create', compact('jenisHewans'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateRasHewan($request);

        try {
            $this->createRasHewan($validatedData);
            
            return redirect()->route('admin.ras-hewan.index')
                             ->with('success', 'Ras hewan berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan ras hewan: ' . $e->getMessage())
                             ->withInput(); 
        }
    }

    public function edit($id)
    {
        $rasHewan = DB::table('ras_hewan')->where('idras_hewan', $id)->first();
        
        if (!$rasHewan) {
            return redirect()->route('admin.ras-hewan.index')->with('error', 'Data tidak ditemukan.');
        }

        $jenisHewans = DB::table('jenis_hewan')->get();
        return view('admin.ras-hewan.edit', compact('rasHewan', 'jenisHewans'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validateRasHewan($request, $id);
        
        $exists = DB::table('ras_hewan')->where('idras_hewan', $id)->exists();
        if (!$exists) {
            return redirect()->route('admin.ras-hewan.index')->with('error', 'Data tidak ditemukan.');
        }

        try {
            $this->updateRasHewan($id, $validatedData);

            return redirect()->route('admin.ras-hewan.index')
                             ->with('success', 'Ras hewan berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui ras hewan: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function showDeleteConfirmation($id)
    {
        $rasHewan = DB::table('ras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select('ras_hewan.*', 'jenis_hewan.nama_jenis_hewan')
            ->where('ras_hewan.idras_hewan', $id)
            ->first();

        if (!$rasHewan) {
            return redirect()->route('admin.ras-hewan.index')->with('error', 'Data tidak ditemukan.');
        }

        $rasHewan->jenisHewan = (object) ['nama_jenis_hewan' => $rasHewan->nama_jenis_hewan];

        return view('admin.ras-hewan.delete', compact('rasHewan'));
    }

    public function destroy($id)
    {
        try {
            DB::table('ras_hewan')->where('idras_hewan', $id)->delete();

            return redirect()->route('admin.ras-hewan.index')
                             ->with('success', 'Ras hewan berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menghapus ras hewan: ' . $e->getMessage());
        }
    }

    // --- Helper Functions ---

    protected function validateRasHewan(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:ras_hewan,nama_ras,' . $id . ',idras_hewan'
                          : 'unique:ras_hewan,nama_ras';

        return $request->validate([
            'nama_ras' => ['required', 'string', 'min:3', 'max:100', $uniqueRule],
            'idjenis_hewan' => ['required', 'integer', 'exists:jenis_hewan,idjenis_hewan'],
        ], [
            'nama_ras.required' => 'Nama ras wajib diisi.',
            'idjenis_hewan.required' => 'Jenis hewan wajib dipilih.',
        ]);
    }

    protected function formatNamaRas($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }

    protected function createRasHewan(array $data)
    {
        try {
            return DB::table('ras_hewan')->insert([
                'nama_ras' => $this->formatNamaRas($data['nama_ras']),
                'idjenis_hewan' => $data['idjenis_hewan'],
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan ras hewan: ' . $e->getMessage());
        }
    }

    protected function updateRasHewan($id, array $data)
    {
        try {
            return DB::table('ras_hewan')
                ->where('idras_hewan', $id)
                ->update([
                    'nama_ras' => $this->formatNamaRas($data['nama_ras']),
                    'idjenis_hewan' => $data['idjenis_hewan'],
                ]);
        } catch (Exception $e) {
            throw new Exception('Gagal memperbarui ras hewan: ' . $e->getMessage());
        }
    }
}