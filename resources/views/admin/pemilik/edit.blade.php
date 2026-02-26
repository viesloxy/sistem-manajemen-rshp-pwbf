@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Profil Pemilik</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.pemilik.index') }}">Data Pemilik</a></li>
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
                        <h3 class="card-title">Form Edit Profil Pemilik</h3>
                    </div>
                    
                    <form action="{{ route('admin.pemilik.update', $pemilik->idpemilik) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- PILIH USER (Dropdown) -->
                            <div class="mb-3">
                                <label for="iduser" class="form-label">Tautkan ke User <span class="text-danger">*</span></label>
                                <select class="form-control @error('iduser') is-invalid @enderror" 
                                        id="iduser" 
                                        name="iduser" 
                                        required>
                                    <option value="">-- Pilih Akun User --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->iduser }}" {{ old('iduser', $pemilik->iduser) == $user->iduser ? 'selected' : '' }}>
                                            {{ $user->nama }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('iduser')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- NO WA -->
                            <div class="mb-3">
                                <label for="no_wa" class="form-label">No. WA</label>
                                <input type="text" 
                                       class="form-control @error('no_wa') is-invalid @enderror" 
                                       id="no_wa" 
                                       name="no_wa" 
                                       value="{{ old('no_wa', $pemilik->no_wa) }}" 
                                       placeholder="cth: 08123456789">
                                @error('no_wa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ALAMAT -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" 
                                          name="alamat" 
                                          rows="3" 
                                          placeholder="Masukkan alamat lengkap">{{ old('alamat', $pemilik->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- FOOTER FIXED: Tombol Kiri-Kanan -->
                        <div class="card-footer" style="background-color: white; padding: 15px;">
                            <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                                <a href="{{ route('admin.pemilik.index') }}" class="btn btn-secondary">
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