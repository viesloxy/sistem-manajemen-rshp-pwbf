<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\SiteController;

use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\PemilikController as AdminPemilikController;
use App\Http\Controllers\Admin\RasHewanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KategoriKlinisController;
use App\Http\Controllers\Admin\KodeTindakanTerapiController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Resepsionis\DashboardResepsionisController;

use App\Http\Controllers\Dokter\DashboardDokterController;
use App\Http\Controllers\Perawat\DashboardPerawatController;
use App\Http\Controllers\Pemilik\DashboardPemilikController;

use App\Http\Controllers\Resepsionis\RegistrasiController;
use App\Http\Controllers\Dokter\RekamMedisController as DokterRekamMedisController;
use App\Http\Controllers\Perawat\RekamMedisController as PerawatRekamMedisController;
use App\Http\Controllers\Pemilik\PetController as PemilikPetController;


/*
|--------------------------------------------------------------------------
| RUTE PUBLIK (Bisa diakses sebelum login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('site.home'); // Lebih baik redirect ke home publik
});

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('site.cek-koneksi');

// Rute publik Anda
Route::get('/home-publik', [SiteController::class, 'index'])->name('site.home'); // Saya ganti namanya agar tidak konflik
Route::get('/struktur-organisasi', [SiteController::class, 'struktur'])->name('struktur');
Route::get('/layanan', [SiteController::class, 'layanan'])->name('layanan');
Route::get('/visi-misi', [SiteController::class, 'visimisi'])->name('visimisi');

/*
|--------------------------------------------------------------------------
| RUTE AUTENTIKASI (Login, Register, Logout)
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| RUTE YANG DILINDUNGI (Hanya bisa diakses SETELAH login)
|--------------------------------------------------------------------------
*/

// Rute Dashboard / Home setelah login (fallback jika tidak ada role)
Route::get('/home', [HomeController::class, 'index'])->name('home');


// ===================================================================
// Rute Grup Middleware ==
// ===================================================================

// --- RUTE UNTUK ADMINISTRATOR (Role 1) ---
// Modifikasi route dengan grouping prefix 'admin' dan name 'admin.'
Route::middleware(['isAdministrator'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function () {
    
    // Dashboard Admin
    Route::get('dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    
    // Rute Admin (Data Master)
    
    // Jenis Hewan
    Route::get('jenis-hewan', [JenisHewanController::class, 'index'])->name('jenis-hewan.index');
    Route::get('jenis-hewan/create', [JenisHewanController::class, 'create'])->name('jenis-hewan.create');
    Route::post('jenis-hewan/store', [JenisHewanController::class, 'store'])->name('jenis-hewan.store');
    Route::get('jenis-hewan/{id}/edit', [JenisHewanController::class, 'edit'])->name('jenis-hewan.edit');
    Route::put('jenis-hewan/{id}/update', [JenisHewanController::class, 'update'])->name('jenis-hewan.update');
    Route::get('jenis-hewan/{id}/delete', [JenisHewanController::class, 'showDeleteConfirmation'])->name('jenis-hewan.delete');
    Route::delete('jenis-hewan/{id}/destroy', [JenisHewanController::class, 'destroy'])->name('jenis-hewan.destroy');

    // User
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('user/{id}/delete', [UserController::class, 'showDeleteConfirmation'])->name('user.delete');
    Route::delete('user/{id}/destroy', [UserController::class, 'destroy'])->name('user.destroy');

    // Role
    Route::get('role', [RoleController::class, 'index'])->name('role.index');
    Route::get('role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('role/{id}/update', [RoleController::class, 'update'])->name('role.update');
    Route::get('role/{id}/delete', [RoleController::class, 'showDeleteConfirmation'])->name('role.delete');
    Route::delete('role/{id}/destroy', [RoleController::class, 'destroy'])->name('role.destroy');

    // Ras Hewan
    Route::get('ras-hewan', [RasHewanController::class, 'index'])->name('ras-hewan.index');
    Route::get('ras-hewan/create', [RasHewanController::class, 'create'])->name('ras-hewan.create');
    Route::post('ras-hewan/store', [RasHewanController::class, 'store'])->name('ras-hewan.store');
    Route::get('ras-hewan/{id}/edit', [RasHewanController::class, 'edit'])->name('ras-hewan.edit');
    Route::put('ras-hewan/{id}/update', [RasHewanController::class, 'update'])->name('ras-hewan.update');
    Route::get('ras-hewan/{id}/delete', [RasHewanController::class, 'showDeleteConfirmation'])->name('ras-hewan.delete');
    Route::delete('ras-hewan/{id}/destroy', [RasHewanController::class, 'destroy'])->name('ras-hewan.destroy');

    // Pemilik
    Route::get('pemilik', [AdminPemilikController::class, 'index'])->name('pemilik.index');
    Route::get('pemilik/create', [AdminPemilikController::class, 'create'])->name('pemilik.create');
    Route::post('pemilik/store', [AdminPemilikController::class, 'store'])->name('pemilik.store');
    Route::get('pemilik/{id}/edit', [AdminPemilikController::class, 'edit'])->name('pemilik.edit');
    Route::put('pemilik/{id}/update', [AdminPemilikController::class, 'update'])->name('pemilik.update');
    Route::get('pemilik/{id}/delete', [AdminPemilikController::class, 'showDeleteConfirmation'])->name('pemilik.delete');
    Route::delete('pemilik/{id}/destroy', [AdminPemilikController::class, 'destroy'])->name('pemilik.destroy');


    // Pet
    Route::get('pet', [PetController::class, 'index'])->name('pet.index');
    Route::get('pet/create', [PetController::class, 'create'])->name('pet.create');
    Route::post('pet/store', [PetController::class, 'store'])->name('pet.store');
    Route::get('pet/{id}/edit', [PetController::class, 'edit'])->name('pet.edit');
    Route::put('pet/{id}/update', [PetController::class, 'update'])->name('pet.update');
    Route::get('pet/{id}/delete', [PetController::class, 'showDeleteConfirmation'])->name('pet.delete');
    Route::delete('pet/{id}/destroy', [PetController::class, 'destroy'])->name('pet.destroy');

    // Kategori
    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('kategori/{id}/update', [KategoriController::class, 'update'])->name('kategori.update');
    Route::get('kategori/{id}/delete', [KategoriController::class, 'showDeleteConfirmation'])->name('kategori.delete');
    Route::delete('kategori/{id}/destroy', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Kategori Klinis
    Route::get('kategori-klinis', [KategoriKlinisController::class, 'index'])->name('kategori-klinis.index');
    Route::get('kategori-klinis/create', [KategoriKlinisController::class, 'create'])->name('kategori-klinis.create');
    Route::post('kategori-klinis/store', [KategoriKlinisController::class, 'store'])->name('kategori-klinis.store');
    Route::get('kategori-klinis/{id}/edit', [KategoriKlinisController::class, 'edit'])->name('kategori-klinis.edit');
    Route::put('kategori-klinis/{id}/update', [KategoriKlinisController::class, 'update'])->name('kategori-klinis.update');
    Route::get('kategori-klinis/{id}/delete', [KategoriKlinisController::class, 'showDeleteConfirmation'])->name('kategori-klinis.delete');
    Route::delete('kategori-klinis/{id}/destroy', [KategoriKlinisController::class, 'destroy'])->name('kategori-klinis.destroy');

    // (BARU) Kode Tindakan Terapi
    Route::get('kode-tindakan-terapi', [KodeTindakanTerapiController::class, 'index'])->name('kode-tindakan-terapi.index');
    Route::get('kode-tindakan-terapi/create', [KodeTindakanTerapiController::class, 'create'])->name('kode-tindakan-terapi.create');
    Route::post('kode-tindakan-terapi/store', [KodeTindakanTerapiController::class, 'store'])->name('kode-tindakan-terapi.store');
    Route::get('kode-tindakan-terapi/{id}/edit', [KodeTindakanTerapiController::class, 'edit'])->name('kode-tindakan-terapi.edit');
    Route::put('kode-tindakan-terapi/{id}/update', [KodeTindakanTerapiController::class, 'update'])->name('kode-tindakan-terapi.update');
    Route::get('kode-tindakan-terapi/{id}/delete', [KodeTindakanTerapiController::class, 'showDeleteConfirmation'])->name('kode-tindakan-terapi.delete');
    Route::delete('kode-tindakan-terapi/{id}/destroy', [KodeTindakanTerapiController::class, 'destroy'])->name('kode-tindakan-terapi.destroy');

});

// --- RUTE UNTUK RESEPSIONIS (Role 4) ---
Route::middleware(['isResepsionis'])->group(function () {

    // Dashboard
    Route::get('/resepsionis/dashboard', [DashboardResepsionisController::class, 'index'])->name('resepsionis.dashboard');

    // 1. MANAJEMEN PEMILIK
    // Tambahkan Route Konfirmasi Hapus (GET) SEBELUM resource
    Route::get('resepsionis/pemilik/{id}/delete', [\App\Http\Controllers\Resepsionis\RegistrasiPemilikController::class, 'showDeleteConfirmation'])->name('resepsionis.pemilik.delete');
    Route::resource('resepsionis/pemilik', \App\Http\Controllers\Resepsionis\RegistrasiPemilikController::class, ['as' => 'resepsionis']);

    // 2. MANAJEMEN PET
    // Tambahkan Route Konfirmasi Hapus (GET) SEBELUM resource
    Route::get('resepsionis/pet/{id}/delete', [\App\Http\Controllers\Resepsionis\RegistrasiPetController::class, 'showDeleteConfirmation'])->name('resepsionis.pet.delete');
    Route::resource('resepsionis/pet', \App\Http\Controllers\Resepsionis\RegistrasiPetController::class, ['as' => 'resepsionis']);

    // 3. TRANSAKSI TEMU DOKTER
    Route::resource('resepsionis/temu-dokter', \App\Http\Controllers\Resepsionis\TemuDokterController::class, ['as' => 'resepsionis']);

});

// ====================================================
// GROUP DOKTER
// ====================================================
Route::middleware(['isDokter'])->prefix('dokter')->name('dokter.')->group(function () {
    
    // Dashboard (Route: dokter.dashboard)
    Route::get('/dashboard', [DashboardDokterController::class, 'index'])->name('dashboard');

    // REKAM MEDIS (Route: dokter.rekam-medis.*)
    // Menggunakan prefix 'rekam-medis' dan name 'rekam-medis.'
    Route::prefix('rekam-medis')->name('rekam-medis.')->group(function () {
        
        // 1. Index (List Pasien) -> route('dokter.rekam-medis.index')
        Route::get('/', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'index'])->name('index');
        
        // 2. Halaman Periksa/Detail -> route('dokter.rekam-medis.edit')
        Route::get('/{id}/periksa', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'edit'])->name('edit');
        
        // 3. Update Diagnosa
        Route::put('/{id}/update-diagnosa', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'updateDiagnosa'])->name('update-diagnosa');
        
        // 4. CRUD Tindakan
        Route::post('/{id}/tindakan/store', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'storeTindakan'])->name('tindakan.store');
        Route::put('/tindakan/{idDetail}/update', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'updateTindakan'])->name('tindakan.update');
        Route::delete('/tindakan/{idDetail}/destroy', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'destroyTindakan'])->name('tindakan.destroy');
        
        // 5. Selesai
        Route::post('/{id}/selesai', [\App\Http\Controllers\Dokter\RekamMedisController::class, 'markAsDone'])->name('selesai');
    });

});

// --- RUTE UNTUK PERAWAT (Role 3) ---
// --- GROUP PERAWAT ---
Route::middleware(['isPerawat'])->prefix('perawat')->name('perawat.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Perawat\DashboardPerawatController::class, 'index'])->name('dashboard');

    // REKAM MEDIS PERAWAT
    // Route ini menangani CRUD Rekam Medis oleh Perawat
    Route::prefix('rekam-medis')->name('rekam-medis.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Perawat\RekamMedisController::class, 'index'])->name('index');
        
        // Buat Baru
        Route::get('/create/{idReservasi}/{idPet}', [\App\Http\Controllers\Perawat\RekamMedisController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Perawat\RekamMedisController::class, 'store'])->name('store');
        
        // Edit & Update Header (Asesmen)
        Route::get('/{id}/edit', [\App\Http\Controllers\Perawat\RekamMedisController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [\App\Http\Controllers\Perawat\RekamMedisController::class, 'update'])->name('update');
        
        // Detail (Show) - INI YANG TADI ERROR, KITA PASTIKAN ADA
        Route::get('/{id}/detail', [\App\Http\Controllers\Perawat\RekamMedisController::class, 'show'])->name('show');
        
        // Delete
        Route::delete('/{id}/destroy', [\App\Http\Controllers\Perawat\RekamMedisController::class, 'destroy'])->name('destroy');

        Route::get('/{id}/delete', [\App\Http\Controllers\Perawat\RekamMedisController::class, 'showDeleteConfirmation'])->name('delete');
    });
});

// ====================================================
// GROUP PEMILIK
// ====================================================
Route::middleware(['isPemilik'])->prefix('pemilik')->name('pemilik.')->group(function () {
    
    // Dashboard
    // View path: resources/views/pemilik/dashboard-pemilik.blade.php
    Route::get('/dashboard', [\App\Http\Controllers\Pemilik\DashboardPemilikController::class, 'index'])->name('dashboard');

    // Pet (Hewan Peliharaan)
    Route::get('/pet', [\App\Http\Controllers\Pemilik\PetListController::class, 'index'])->name('pet.list');
    Route::get('/pet/{id}', [\App\Http\Controllers\Pemilik\PetListController::class, 'show'])->name('pet.show');

    // Temu Dokter (Dulu Reservasi)
    Route::get('/temu-dokter', [\App\Http\Controllers\Pemilik\TemuDokterController::class, 'index'])->name('temu-dokter.list');
    Route::post('/temu-dokter/store', [\App\Http\Controllers\Pemilik\TemuDokterController::class, 'store'])->name('temu-dokter.store');
    Route::post('/temu-dokter/{id}/cancel', [\App\Http\Controllers\Pemilik\TemuDokterController::class, 'cancel'])->name('temu-dokter.cancel');

    // Rekam Medis (History)
    Route::get('/rekam-medis', [\App\Http\Controllers\Pemilik\RekamMedisPemController::class, 'index'])->name('rekammedis.list');
    Route::get('/rekam-medis/{id}', [\App\Http\Controllers\Pemilik\RekamMedisPemController::class, 'show'])->name('rekammedis.show');

});