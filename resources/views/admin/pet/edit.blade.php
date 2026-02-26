@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Data Pet</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.pet.index') }}">Data Pet</a></li>
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
                        <h3 class="card-title">Form Edit Data Pet</h3>
                    </div>
                    
                    <form action="{{ route('admin.pet.update', $pet->idpet) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- NAMA PET -->
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Pet <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama', $pet->nama) }}" 
                                       required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PEMILIK (Dropdown) -->
                            <div class="mb-3">
                                <label for="idpemilik" class="form-label">Pemilik <span class="text-danger">*</span></label>
                                <select class="form-control @error('idpemilik') is-invalid @enderror" 
                                        id="idpemilik" 
                                        name="idpemilik" 
                                        required>
                                    <option value="">-- Pilih Pemilik --</option>
                                    @foreach ($pemilik as $p)
                                        <option value="{{ $p->idpemilik }}" {{ old('idpemilik', $pet->idpemilik) == $p->idpemilik ? 'selected' : '' }}>
                                            {{ $p->user->nama ?? 'User Error' }} ({{ $p->user->email ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('idpemilik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- RAS HEWAN (Dropdown) -->
                            <div class="mb-3">
                                <label for="idras_hewan" class="form-label">Ras Hewan <span class="text-danger">*</span></label>
                                <select class="form-control @error('idras_hewan') is-invalid @enderror" 
                                        id="idras_hewan" 
                                        name="idras_hewan" 
                                        required>
                                    <option value="">-- Pilih Ras Hewan --</option>
                                    @foreach ($rasHewan as $ras)
                                        <option value="{{ $ras->idras_hewan }}" {{ old('idras_hewan', $pet->idras_hewan) == $ras->idras_hewan ? 'selected' : '' }}>
                                            {{ $ras->nama_ras }} ({{ $ras->jenisHewan->nama_jenis_hewan ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('idras_hewan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- TANGGAL LAHIR -->
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" 
                                       class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                       id="tanggal_lahir" 
                                       name="tanggal_lahir"
                                       value="{{ old('tanggal_lahir', $pet->tanggal_lahir) }}">
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- JENIS KELAMIN (Dropdown) -->
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-control @error('jenis_kelamin') is-invalid @enderror" 
                                        id="jenis_kelamin" 
                                        name="jenis_kelamin" 
                                        required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="J" {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'J' ? 'selected' : '' }}>Jantan</option>
                                    <option value="B" {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'B' ? 'selected' : '' }}>Betina</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- WARNA / TANDA -->
                            <div class="mb-3">
                                <label for="warna_tanda" class="form-label">Warna / Tanda Khusus</label>
                                <textarea class="form-control @error('warna_tanda') is-invalid @enderror" 
                                          id="warna_tanda" 
                                          name="warna_tanda" 
                                          rows="3" 
                                          placeholder="cth: Coklat muda dengan kaos kaki putih di kaki kiri">{{ old('warna_tanda', $pet->warna_tanda) }}</textarea>
                                @error('warna_tanda')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- FOOTER FIXED: Tombol Kiri-Kanan -->
                        <div class="card-footer" style="background-color: white; padding: 15px;">
                            <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                                <a href="{{ route('admin.pet.index') }}" class="btn btn-secondary">
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