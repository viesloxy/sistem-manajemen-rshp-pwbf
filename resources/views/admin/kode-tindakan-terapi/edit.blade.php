@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Kode Tindakan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.kode-tindakan-terapi.index') }}">Kode Tindakan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Data</h3>
                    </div>
                    
                    <form action="{{ route('admin.kode-tindakan-terapi.update', $kodeTindakanTerapi->idkode_tindakan_terapi) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- KODE -->
                            <div class="mb-3">
                                <label for="kode" class="form-label">Kode <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('kode') is-invalid @enderror" 
                                       id="kode" 
                                       name="kode" 
                                       value="{{ old('kode', $kodeTindakanTerapi->kode) }}" 
                                       required>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- DESKRIPSI -->
                            <div class="mb-3">
                                <label for="deskripsi_tindakan_terapi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('deskripsi_tindakan_terapi') is-invalid @enderror" 
                                          id="deskripsi_tindakan_terapi" 
                                          name="deskripsi_tindakan_terapi" 
                                          rows="3" 
                                          required>{{ old('deskripsi_tindakan_terapi', $kodeTindakanTerapi->deskripsi_tindakan_terapi) }}</textarea>
                                @error('deskripsi_tindakan_terapi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- KATEGORI (Dropdown) -->
                            <div class="mb-3">
                                <label for="idkategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control @error('idkategori') is-invalid @enderror" 
                                        id="idkategori" 
                                        name="idkategori" 
                                        required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->idkategori }}" {{ old('idkategori', $kodeTindakanTerapi->idkategori) == $kategori->idkategori ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idkategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- KATEGORI KLINIS (Dropdown) -->
                            <div class="mb-3">
                                <label for="idkategori_klinis" class="form-label">Kategori Klinis <span class="text-danger">*</span></label>
                                <select class="form-control @error('idkategori_klinis') is-invalid @enderror" 
                                        id="idkategori_klinis" 
                                        name="idkategori_klinis" 
                                        required>
                                    <option value="">-- Pilih Kategori Klinis --</option>
                                    @foreach ($kategoriKlinis as $klinis)
                                        <option value="{{ $klinis->idkategori_klinis }}" {{ old('idkategori_klinis', $kodeTindakanTerapi->idkategori_klinis) == $klinis->idkategori_klinis ? 'selected' : '' }}>
                                            {{ $klinis->nama_kategori_klinis }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idkategori_klinis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- FOOTER FIXED: Tombol Kiri-Kanan -->
                        <div class="card-footer" style="background-color: white; padding: 15px;">
                            <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                                <a href="{{ route('admin.kode-tindakan-terapi.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-warning text-white">
                                    <i class="bi bi-save me-1"></i> Update
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection