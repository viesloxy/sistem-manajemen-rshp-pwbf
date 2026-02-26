<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import Facade DB
use Exception;

class RoleController extends Controller
{
    public function index()
    {
        $roles = DB::table('role')->get();
        return view('admin.role.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateRole($request);

        try {
            $this->createRole($validatedData);
            
            return redirect()->route('admin.role.index')
                             ->with('success', 'Role berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan role: ' . $e->getMessage())
                             ->withInput(); 
        }
    }

    public function edit($id)
    {
        $role = DB::table('role')->where('idrole', $id)->first();

        if (!$role) {
            return redirect()->route('admin.role.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validateRole($request, $id);
        
        $exists = DB::table('role')->where('idrole', $id)->exists();
        if (!$exists) {
            return redirect()->route('admin.role.index')->with('error', 'Data tidak ditemukan.');
        }

        try {
            $this->updateRole($id, $validatedData);

            return redirect()->route('admin.role.index')
                             ->with('success', 'Role berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui role: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function showDeleteConfirmation($id)
    {
        $role = DB::table('role')->where('idrole', $id)->first();
        
        if (!$role) {
            return redirect()->route('admin.role.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.role.delete', compact('role'));
    }

    public function destroy($id)
    {
        try {
            DB::table('role')->where('idrole', $id)->delete();

            return redirect()->route('admin.role.index')
                             ->with('success', 'Role berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menghapus role: ' . $e->getMessage());
        }
    }

    // --- Helper Functions ---

    protected function validateRole(Request $request, $id = null)
    {
        $uniqueRule = $id ? 'unique:role,nama_role,' . $id . ',idrole'
                          : 'unique:role,nama_role';

        return $request->validate([
            'nama_role' => ['required', 'string', 'min:3', 'max:100', $uniqueRule],
        ], [
            'nama_role.required' => 'Nama role wajib diisi.',
            'nama_role.unique' => 'Nama role ini sudah ada.',
        ]);
    }

    protected function formatNamaRole($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }

    protected function createRole(array $data)
    {
        try {
            return DB::table('role')->insert([
                'nama_role' => $this->formatNamaRole($data['nama_role']),
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan role: ' . $e->getMessage());
        }
    }

    protected function updateRole($id, array $data)
    {
        try {
            return DB::table('role')
                ->where('idrole', $id)
                ->update([
                    'nama_role' => $this->formatNamaRole($data['nama_role']),
                ]);
        } catch (Exception $e) {
            throw new Exception('Gagal memperbarui role: ' . $e->getMessage());
        }
    }
}