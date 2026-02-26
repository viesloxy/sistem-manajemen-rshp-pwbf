<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import Facade DB
use Exception;

class KodeTindakanTerapiController extends Controller
{
    public function index()
    {
        // Query Builder dengan Join
        $kodeTindakanTerapi = DB::table('kode_tindakan_terapi')
            ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
            ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
            ->select(
                'kode_tindakan_terapi.*', 
                'kategori.nama_kategori', 
                'kategori_klinis.nama_kategori_klinis'
            )
            ->get();

        // Format data agar kompatibel dengan View ($item->kategori->nama_kategori)
        $formattedData = $kodeTindakanTerapi->map(function($item) {
            $item->kategori = (object) ['nama_kategori' => $item->nama_kategori];
            $item->kategoriKlinis = (object) ['nama_kategori_klinis' => $item->nama_kategori_klinis];
            return $item;
        });

        return view('admin.kode-tindakan-terapi.index', ['kodeTindakanTerapi' => $formattedData]);
    }

    public function create()
    {
        $kategoris = DB::table('kategori')->get();
        $kategoriKlinis = DB::table('kategori_klinis')->get();

        return view('admin.kode-tindakan-terapi.create', compact('kategoris', 'kategoriKlinis'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateKodeTindakanTerapi($request);

        try {
            $this->createKodeTindakanTerapi($validatedData);
            
            return redirect()->route('admin.kode-tindakan-terapi.index')
                             ->with('success', 'Kode tindakan terapi berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan kode tindakan terapi: ' . $e->getMessage())
                             ->withInput(); 
        }
    }

    public function edit($id)
    {
        $kodeTindakanTerapi = DB::table('kode_tindakan_terapi')->where('idkode_tindakan_terapi', $id)->first();
        
        if (!$kodeTindakanTerapi) {
            return redirect()->route('admin.kode-tindakan-terapi.index')->with('error', 'Data tidak ditemukan.');
        }

        $kategoris = DB::table('kategori')->get();
        $kategoriKlinis = DB::table('kategori_klinis')->get();

        return view('admin.kode-tindakan-terapi.edit', compact('kodeTindakanTerapi', 'kategoris', 'kategoriKlinis'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validateKodeTindakanTerapi($request, $id);
        
        $exists = DB::table('kode_tindakan_terapi')->where('idkode_tindakan_terapi', $id)->exists();
        if (!$exists) {
            return redirect()->route('admin.kode-tindakan-terapi.index')->with('error', 'Data tidak ditemukan.');
        }

        try {
            $this->updateKodeTindakanTerapi($id, $validatedData);

            return redirect()->route('admin.kode-tindakan-terapi.index')
                             ->with('success', 'Kode tindakan terapi berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui kode tindakan terapi: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function showDeleteConfirmation($id)
    {
        $kodeTindakanTerapi = DB::table('kode_tindakan_terapi')
            ->join('kategori', 'kode_tindakan_terapi.idkategori', '=', 'kategori.idkategori')
            ->join('kategori_klinis', 'kode_tindakan_terapi.idkategori_klinis', '=', 'kategori_klinis.idkategori_klinis')
            ->select(
                'kode_tindakan_terapi.*', 
                'kategori.nama_kategori', 
                'kategori_klinis.nama_kategori_klinis'
            )
            ->where('kode_tindakan_terapi.idkode_tindakan_terapi', $id)
            ->first();

        if (!$kodeTindakanTerapi) {
            return redirect()->route('admin.kode-tindakan-terapi.index')->with('error', 'Data tidak ditemukan.');
        }

        // Format ulang untuk view
        $kodeTindakanTerapi->kategori = (object) ['nama_kategori' => $kodeTindakanTerapi->nama_kategori];
        $kodeTindakanTerapi->kategoriKlinis = (object) ['nama_kategori_klinis' => $kodeTindakanTerapi->nama_kategori_klinis];

        return view('admin.kode-tindakan-terapi.delete', compact('kodeTindakanTerapi'));
    }

    public function destroy($id)
    {
        try {
            DB::table('kode_tindakan_terapi')->where('idkode_tindakan_terapi', $id)->delete();

            return redirect()->route('admin.kode-tindakan-terapi.index')
                             ->with('success', 'Kode tindakan terapi berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menghapus kode tindakan terapi: ' . $e->getMessage());
        }
    }

    // --- Helper Functions ---

    protected function validateKodeTindakanTerapi(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:kode_tindakan_terapi,kode,' . $id . ',idkode_tindakan_terapi'
                          : 'unique:kode_tindakan_terapi,kode';

        return $request->validate([
            'kode' => ['required', 'string', 'max:5', $uniqueRule],
            'deskripsi_tindakan_terapi' => ['required', 'string', 'max:1000'],
            'idkategori' => ['required', 'integer', 'exists:kategori,idkategori'],
            'idkategori_klinis' => ['required', 'integer', 'exists:kategori_klinis,idkategori_klinis'],
        ], [
            'kode.required' => 'Kode wajib diisi.',
            'kode.unique' => 'Kode ini sudah digunakan.',
            'deskripsi_tindakan_terapi.required' => 'Deskripsi wajib diisi.',
            'idkategori.required' => 'Kategori wajib dipilih.',
            'idkategori_klinis.required' => 'Kategori klinis wajib dipilih.',
        ]);
    }

    protected function createKodeTindakanTerapi(array $data)
    {
        try {
            return DB::table('kode_tindakan_terapi')->insert($data);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    protected function updateKodeTindakanTerapi($id, array $data)
    {
        try {
            return DB::table('kode_tindakan_terapi')
                ->where('idkode_tindakan_terapi', $id)
                ->update($data);
        } catch (Exception $e) {
            throw new Exception('Gagal memperbarui data: ' . $e->getMessage());
        }
    }
}