<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import Facade DB
use Exception;

class KategoriKlinisController extends Controller
{
    public function index()
    {
        $kategoriKlinis = DB::table('kategori_klinis')->get();
        return view('admin.kategori-klinis.index', compact('kategoriKlinis'));
    }

    public function create()
    {
        return view('admin.kategori-klinis.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateKategoriKlinis($request);

        try {
            $this->createKategoriKlinis($validatedData);
            
            return redirect()->route('admin.kategori-klinis.index')
                             ->with('success', 'Kategori klinis berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan kategori klinis: ' . $e->getMessage())
                             ->withInput(); 
        }
    }

    public function edit($id)
    {
        $kategoriKlinis = DB::table('kategori_klinis')->where('idkategori_klinis', $id)->first();

        if (!$kategoriKlinis) {
            return redirect()->route('admin.kategori-klinis.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.kategori-klinis.edit', compact('kategoriKlinis'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validateKategoriKlinis($request, $id);
        
        $exists = DB::table('kategori_klinis')->where('idkategori_klinis', $id)->exists();
        if (!$exists) {
            return redirect()->route('admin.kategori-klinis.index')->with('error', 'Data tidak ditemukan.');
        }

        try {
            $this->updateKategoriKlinis($id, $validatedData);

            return redirect()->route('admin.kategori-klinis.index')
                             ->with('success', 'Kategori klinis berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui kategori klinis: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function showDeleteConfirmation($id)
    {
        $kategoriKlinis = DB::table('kategori_klinis')->where('idkategori_klinis', $id)->first();
        
        if (!$kategoriKlinis) {
            return redirect()->route('admin.kategori-klinis.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.kategori-klinis.delete', compact('kategoriKlinis'));
    }

    public function destroy($id)
    {
        try {
            DB::table('kategori_klinis')->where('idkategori_klinis', $id)->delete();

            return redirect()->route('admin.kategori-klinis.index')
                             ->with('success', 'Kategori klinis berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menghapus kategori klinis: ' . $e->getMessage());
        }
    }

    // --- Helper Functions ---

    protected function validateKategoriKlinis(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:kategori_klinis,nama_kategori_klinis,' . $id . ',idkategori_klinis'
                          : 'unique:kategori_klinis,nama_kategori_klinis';

        return $request->validate([
            'nama_kategori_klinis' => ['required', 'string', 'min:3', 'max:50', $uniqueRule],
        ], [
            'nama_kategori_klinis.required' => 'Nama kategori klinis wajib diisi.',
            'nama_kategori_klinis.min' => 'Nama kategori klinis minimal 3 karakter.',
            'nama_kategori_klinis.max' => 'Nama kategori klinis maksimal 50 karakter.',
            'nama_kategori_klinis.unique' => 'Nama kategori klinis ini sudah ada.',
        ]);
    }

    protected function formatNamaKategoriKlinis($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }

    protected function createKategoriKlinis(array $data)
    {
        try {
            return DB::table('kategori_klinis')->insert([
                'nama_kategori_klinis' => $this->formatNamaKategoriKlinis($data['nama_kategori_klinis']),
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan kategori klinis: ' . $e->getMessage());
        }
    }

    protected function updateKategoriKlinis($id, array $data)
    {
        try {
            return DB::table('kategori_klinis')
                ->where('idkategori_klinis', $id)
                ->update([
                    'nama_kategori_klinis' => $this->formatNamaKategoriKlinis($data['nama_kategori_klinis']),
                ]);
        } catch (Exception $e) {
            throw new Exception('Gagal memperbarui kategori klinis: ' . $e->getMessage());
        }
    }
}