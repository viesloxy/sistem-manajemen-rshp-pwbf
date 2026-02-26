<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import Facade DB
use Carbon\Carbon;
use Exception;

class PetController extends Controller
{
    public function index()
    {
        $pet = DB::table('pet')
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
            ->get();

        // Format dan Accessor Manual
        $formattedData = $pet->map(function($item) {
            $item->pemilik = (object) ['user' => (object) ['nama' => $item->nama_pemilik]];
            $item->rasHewan = (object) [
                'nama_ras' => $item->nama_ras,
                'jenisHewan' => (object) ['nama_jenis_hewan' => $item->nama_jenis_hewan]
            ];
            
            // Accessor Usia
            if (!$item->tanggal_lahir) {
                $item->usia = 'N/A';
            } else {
                $umur = Carbon::parse($item->tanggal_lahir)->diff(Carbon::now());
                $item->usia = $umur->format('%y thn, %m bln, %d hr');
            }

            // Accessor Jenis Kelamin
            if ($item->jenis_kelamin == 'J') {
                $item->jenis_kelamin_text = 'Jantan';
            } elseif ($item->jenis_kelamin == 'B') {
                $item->jenis_kelamin_text = 'Betina';
            } else {
                $item->jenis_kelamin_text = 'N/A';
            }

            return $item;
        });

        return view('admin.pet.index', ['pet' => $formattedData]);
    }

    public function create()
    {
        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.idpemilik', 'user.nama', 'user.email')
            ->get()
            ->map(function($p) {
                $p->user = (object) ['nama' => $p->nama, 'email' => $p->email];
                return $p;
            });

        $rasHewan = DB::table('ras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select('ras_hewan.idras_hewan', 'ras_hewan.nama_ras', 'jenis_hewan.nama_jenis_hewan')
            ->get()
            ->map(function($r) {
                $r->jenisHewan = (object) ['nama_jenis_hewan' => $r->nama_jenis_hewan];
                return $r;
            });

        return view('admin.pet.create', compact('pemilik', 'rasHewan'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validatePet($request);

        try {
            $this->createPet($validatedData);
            
            return redirect()->route('admin.pet.index')
                             ->with('success', 'Data pet berhasil ditambahkan.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menyimpan data pet: ' . $e->getMessage())
                             ->withInput(); 
        }
    }

    public function edit($id)
    {
        $pet = DB::table('pet')->where('idpet', $id)->first();

        if (!$pet) {
            return redirect()->route('admin.pet.index')->with('error', 'Data tidak ditemukan.');
        }

        $pemilik = DB::table('pemilik')
            ->join('user', 'pemilik.iduser', '=', 'user.iduser')
            ->select('pemilik.idpemilik', 'user.nama', 'user.email')
            ->get()
            ->map(function($p) {
                $p->user = (object) ['nama' => $p->nama, 'email' => $p->email];
                return $p;
            });

        $rasHewan = DB::table('ras_hewan')
            ->join('jenis_hewan', 'ras_hewan.idjenis_hewan', '=', 'jenis_hewan.idjenis_hewan')
            ->select('ras_hewan.idras_hewan', 'ras_hewan.nama_ras', 'jenis_hewan.nama_jenis_hewan')
            ->get()
            ->map(function($r) {
                $r->jenisHewan = (object) ['nama_jenis_hewan' => $r->nama_jenis_hewan];
                return $r;
            });

        return view('admin.pet.edit', compact('pet', 'pemilik', 'rasHewan'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $this->validatePet($request, $id);
        
        $exists = DB::table('pet')->where('idpet', $id)->exists();
        if (!$exists) {
            return redirect()->route('admin.pet.index')->with('error', 'Data tidak ditemukan.');
        }

        try {
            $this->updatePet($id, $validatedData);

            return redirect()->route('admin.pet.index')
                             ->with('success', 'Data pet berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui data pet: ' . $e->getMessage())
                             ->withInput();
        }
    }

    public function showDeleteConfirmation($id)
    {
        $pet = DB::table('pet')
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
            ->where('pet.idpet', $id)
            ->first();

        if (!$pet) {
            return redirect()->route('admin.pet.index')->with('error', 'Data tidak ditemukan.');
        }

        // Format object untuk view delete
        $pet->pemilik = (object) ['user' => (object) ['nama' => $pet->nama_pemilik]];
        $pet->rasHewan = (object) [
            'nama_ras' => $pet->nama_ras,
            'jenisHewan' => (object) ['nama_jenis_hewan' => $pet->nama_jenis_hewan]
        ];
        
        // Accessor manual
        if (!$pet->tanggal_lahir) {
            $pet->usia = 'N/A';
        } else {
            $umur = Carbon::parse($pet->tanggal_lahir)->diff(Carbon::now());
            $pet->usia = $umur->format('%y thn, %m bln, %d hr');
        }

        return view('admin.pet.delete', compact('pet'));
    }

    public function destroy($id)
    {
        try {
            DB::table('pet')->where('idpet', $id)->delete();

            return redirect()->route('admin.pet.index')
                             ->with('success', 'Data pet berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menghapus data pet: ' . $e->getMessage());
        }
    }

    // --- Helper Functions ---

    protected function validatePet(Request $request, $id = null)
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'warna_tanda' => ['nullable', 'string', 'max:45'],
            'jenis_kelamin' => ['required', 'string', 'in:J,B'],
            'idpemilik' => ['required', 'integer', 'exists:pemilik,idpemilik'],
            'idras_hewan' => ['required', 'integer', 'exists:ras_hewan,idras_hewan'],
        ], [
            'nama.required' => 'Nama pet wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'idpemilik.required' => 'Pemilik wajib dipilih.',
            'idras_hewan.required' => 'Ras hewan wajib dipilih.',
        ]);
    }

    protected function createPet(array $data)
    {
        try {
            return DB::table('pet')->insert([
                'nama' => $data['nama'],
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'warna_tanda' => $data['warna_tanda'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'],
                'idpemilik' => $data['idpemilik'],
                'idras_hewan' => $data['idras_hewan'],
            ]);
        } catch (Exception $e) {
            throw new Exception('Gagal menyimpan data pet: ' . $e->getMessage());
        }
    }

    protected function updatePet($id, array $data)
    {
        try {
            return DB::table('pet')
                ->where('idpet', $id)
                ->update([
                    'nama' => $data['nama'],
                    'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                    'warna_tanda' => $data['warna_tanda'] ?? null,
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'idpemilik' => $data['idpemilik'],
                    'idras_hewan' => $data['idras_hewan'],
                ]);
        } catch (Exception $e) {
            throw new Exception('Gagal memperbarui data pet: ' . $e->getMessage());
        }
    }
}