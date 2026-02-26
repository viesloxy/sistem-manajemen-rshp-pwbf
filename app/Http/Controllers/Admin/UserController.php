<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import Facade DB
use Illuminate\Support\Facades\Hash;
use Exception;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table('user')->get();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateUser($request);

        try {
            $this->createUser($validatedData);
            
            return redirect()->route('admin.user.index')
                             ->with('success', 'User berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan user: ' . $e->getMessage())
                             ->withInput(); 
        }
    }

    public function edit($id)
    {
        $user = DB::table('user')->where('iduser', $id)->first();

        if (!$user) {
            return redirect()->route('admin.user.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validateUser($request, $id);
        
        $exists = DB::table('user')->where('iduser', $id)->exists();
        if (!$exists) {
            return redirect()->route('admin.user.index')->with('error', 'Data tidak ditemukan.');
        }

        try {
            $this->updateUser($id, $validatedData);

            return redirect()->route('admin.user.index')
                             ->with('success', 'User berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui user: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function showDeleteConfirmation($id)
    {
        $user = DB::table('user')->where('iduser', $id)->first();
        
        if (!$user) {
            return redirect()->route('admin.user.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin.user.delete', compact('user'));
    }

    public function destroy($id)
    {
        try {
            DB::table('user')->where('iduser', $id)->delete();

            return redirect()->route('admin.user.index')
                             ->with('success', 'User berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    // --- Helper Functions ---

    protected function validateUser(Request $request, $id = null)
    {
        $uniqueEmailRule = $id ? 'unique:user,email,' . $id . ',iduser'
                               : 'unique:user,email';

        $passwordRule = $id ? 'nullable' : 'required';

        return $request->validate([
            'nama' => ['required', 'string', 'max:500'],
            'email' => ['required', 'string', 'email', 'max:200', $uniqueEmailRule],
            'password' => [$passwordRule, 'string', 'min:8', 'confirmed'],
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
        ]);
    }

    protected function createUser(array $data)
    {
        try {
            return DB::table('user')->insert([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan user: ' . $e->getMessage());
        }
    }

    protected function updateUser($id, array $data)
    {
        try {
            $updateData = [
                'nama' => $data['nama'],
                'email' => $data['email'],
            ];

            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            return DB::table('user')->where('iduser', $id)->update($updateData);
        } catch (Exception $e) {
            throw new Exception('Gagal memperbarui user: ' . $e->getMessage());
        }
    }
}