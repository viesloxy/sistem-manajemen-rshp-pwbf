<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class JenisHewanController extends Controller
{
    /**
     * Menampilkan semua data (Read)
     * Menggunakan Query Builder: DB::table()->get()
     */
    public function index()
    {
        // Eloquent (Lama): 
        // $jenisHewan = JenisHewan::all();

        // Query Builder (Baru - Modul 12):
        // Mengambil data langsung dari tabel 'jenis_hewan'
        $jenisHewan = DB::table('jenis_hewan')
                        ->select('idjenis_hewan', 'nama_jenis_hewan')
                        ->get(); // Mengembalikan Collection of stdClass objects

        return view('admin.jenis-hewan.index', compact('jenisHewan'));
    }

    /**
     * Menampilkan form create
     */
    public function create()
    {
        return view('admin.jenis-hewan.create');
    }

    /**
     * Menyimpan data baru (Create)
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $this->validateJenisHewan($request);

        try {
            // Helper untuk menyimpan data (Menggunakan Query Builder)
            $this->createJenisHewan($validatedData);
            
            return redirect()->route('admin.jenis-hewan.index')
                             ->with('success', 'Jenis hewan berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan data jenis hewan: ' . $e->getMessage())
                             ->withInput(); 
        }
    }

    /**
     * Menampilkan form edit (Read Single)
     * Menggunakan Query Builder: DB::table()->where()->first()
     */
    public function edit($id)
    {
        // Eloquent (Lama):
        // $jenisHewan = JenisHewan::findOrFail($id);

        // Query Builder (Baru):
        $jenisHewan = DB::table('jenis_hewan')
                        ->where('idjenis_hewan', $id)
                        ->first(); // Mengambil satu baris data

        if (!$jenisHewan) {
            return redirect()->route('admin.jenis-hewan.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.jenis-hewan.edit', compact('jenisHewan'));
    }

    /**
     * Mengupdate data (Update)
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $this->validateJenisHewan($request, $id);
        
        // Cek keberadaan data dulu
        $exists = DB::table('jenis_hewan')->where('idjenis_hewan', $id)->exists();
        if (!$exists) {
            return redirect()->route('admin.jenis-hewan.index')->with('error', 'Data tidak ditemukan.');
        }

        try {
            // Helper untuk update data (Menggunakan Query Builder)
            $this->updateJenisHewan($id, $validatedData);

            return redirect()->route('admin.jenis-hewan.index')
                             ->with('success', 'Jenis hewan berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui data jenis hewan: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Menampilkan halaman konfirmasi hapus
     */
    public function showDeleteConfirmation($id)
    {
        // Query Builder
        $jenisHewan = DB::table('jenis_hewan')->where('idjenis_hewan', $id)->first();
        
        if (!$jenisHewan) {
            return redirect()->route('admin.jenis-hewan.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.jenis-hewan.delete', compact('jenisHewan'));
    }

    /**
     * Menghapus data (Delete)
     * Menggunakan Query Builder: DB::table()->where()->delete()
     */
    public function destroy($id)
    {
        try {
            // Eloquent (Lama):
            // $jenisHewan = JenisHewan::findOrFail($id);
            // $jenisHewan->delete();

            // Query Builder (Baru):
            DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->delete();

            return redirect()->route('admin.jenis-hewan.index')
                             ->with('success', 'Jenis hewan berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menghapus data jenis hewan: ' . $e->getMessage());
        }
    }

    // -------------------------------------------------------------------
    //  VALIDATION & HELPER FUNCTIONS
    // -------------------------------------------------------------------

    /**
     * Validasi data
     */
    protected function validateJenisHewan(Request $request, $id = null)
    {
        // Rule unique tetap bekerja sama baik dengan Eloquent maupun Query Builder
        // karena validasi Laravel mengecek langsung ke database
        $uniqueRule = $id ? 'unique:jenis_hewan,nama_jenis_hewan,' . $id . ',idjenis_hewan'
                          : 'unique:jenis_hewan,nama_jenis_hewan';

        return $request->validate([
            'nama_jenis_hewan' => [
                'required',
                'string',
                'max:255',
                'min:3',
                $uniqueRule
            ]
        ], [
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
            'nama_jenis_hewan.string' => 'Nama jenis hewan harus berupa teks.',
            'nama_jenis_hewan.max' => 'Nama jenis hewan maksimal 255 karakter.',
            'nama_jenis_hewan.min' => 'Nama jenis hewan minimal 3 karakter.',
            'nama_jenis_hewan.unique' => 'Nama jenis hewan sudah ada.',
        ]);
    }

    /**
     * Helper untuk membuat data baru (CREATE)
     * Menggunakan Query Builder: insert()
     */
    protected function createJenisHewan(array $data)
    {
        try {
            // Query Builder Insert
            // insert() mengembalikan true/false, bukan objek model
            return DB::table('jenis_hewan')->insert([
                'nama_jenis_hewan' => $this->formatNamaJenisHewan($data['nama_jenis_hewan']),
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan data jenis hewan: ' . $e->getMessage());
        }
    }

    /**
     * Helper untuk mengupdate data (UPDATE)
     * Menggunakan Query Builder: update()
     */
    protected function updateJenisHewan($id, array $data)
    {
        try {
            // Query Builder Update
            return DB::table('jenis_hewan')
                ->where('idjenis_hewan', $id)
                ->update([
                    'nama_jenis_hewan' => $this->formatNamaJenisHewan($data['nama_jenis_hewan']),
                ]);
        } catch (Exception $e) {
            throw new Exception('Gagal memperbarui data jenis hewan: ' . $e->getMessage());
        }
    }

    /**
     * Helper untuk format nama menjadi Title Case
     */
    protected function formatNamaJenisHewan($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}