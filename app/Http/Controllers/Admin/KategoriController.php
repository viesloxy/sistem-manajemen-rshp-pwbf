<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import Facade DB
use Exception;

class KategoriController extends Controller
{
    public function index()
    {
        // Query Builder: Ambil semua data
        $kategori = DB::table('kategori')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateKategori($request);

        try {
            // Query Builder: Insert
            $this->createKategori($validatedData);
            
            return redirect()->route('admin.kategori.index')
                             ->with('success', 'Kategori berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan kategori: ' . $e->getMessage())
                             ->withInput(); 
        }
    }

    public function edit($id)
    {
        // Query Builder: Ambil satu data
        $kategori = DB::table('kategori')->where('idkategori', $id)->first();

        if (!$kategori) {
            return redirect()->route('admin.kategori.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validateKategori($request, $id);
        
        // Query Builder: Cek exist
        $exists = DB::table('kategori')->where('idkategori', $id)->exists();
        if (!$exists) {
            return redirect()->route('admin.kategori.index')->with('error', 'Data tidak ditemukan.');
        }

        try {
            // Query Builder: Update
            $this->updateKategori($id, $validatedData);

            return redirect()->route('admin.kategori.index')
                             ->with('success', 'Kategori berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function showDeleteConfirmation($id)
    {
        $kategori = DB::table('kategori')->where('idkategori', $id)->first();
        
        if (!$kategori) {
            return redirect()->route('admin.kategori.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.kategori.delete', compact('kategori'));
    }

    public function destroy($id)
    {
        try {
            // Query Builder: Delete
            DB::table('kategori')->where('idkategori', $id)->delete();

            return redirect()->route('admin.kategori.index')
                             ->with('success', 'Kategori berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }

    // --- Helper Functions ---

    protected function validateKategori(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:kategori,nama_kategori,' . $id . ',idkategori'
                          : 'unique:kategori,nama_kategori';

        return $request->validate([
            'nama_kategori' => ['required', 'string', 'min:3', 'max:100', $uniqueRule],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.min' => 'Nama kategori minimal 3 karakter.',
            'nama_kategori.unique' => 'Nama kategori ini sudah ada.',
        ]);
    }

    protected function formatNamaKategori($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }

    protected function createKategori(array $data)
    {
        try {
            return DB::table('kategori')->insert([
                'nama_kategori' => $this->formatNamaKategori($data['nama_kategori']),
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan kategori: ' . $e->getMessage());
        }
    }

    protected function updateKategori($id, array $data)
    {
        try {
            return DB::table('kategori')
                ->where('idkategori', $id)
                ->update([
                    'nama_kategori' => $this->formatNamaKategori($data['nama_kategori']),
                ]);
        } catch (Exception $e) {
            throw new Exception('Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }
}