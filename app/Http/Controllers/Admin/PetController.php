<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pet;

class PetController extends Controller
{
        public function index()
    {
        // 2. Ambil data Pet, tapi dengan relasi yang di-load:
        //    - 'pemilik.user': Load relasi 'pemilik', dan di dalam 'pemilik', load 'user'
        //    - 'rasHewan.jenisHewan': Load relasi 'rasHewan', dan di dalam 'rasHewan', load 'jenisHewan'
        
        $pet = Pet::with(['pemilik.user', 'rasHewan.jenisHewan'])->get();
        
        // 3. Kirim data ke view
        return view('admin.pet.index', compact('pet'));
    }
}
