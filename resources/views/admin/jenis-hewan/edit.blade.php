@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Jenis Hewan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.jenis-hewan.index') }}">Jenis Hewan</a></li>
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
                        <h3 class="card-title"><i class="bi bi-pencil-square me-1"></i> Form Edit Data</h3>
                    </div>
                    
                    <form action="{{ route('admin.jenis-hewan.update', $jenisHewan->idjenis_hewan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="nama_jenis_hewan" class="form-label">Nama Jenis Hewan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nama_jenis_hewan') is-invalid @enderror" 
                                       id="nama_jenis_hewan" 
                                       name="nama_jenis_hewan" 
                                       value="{{ old('nama_jenis_hewan', $jenisHewan->nama_jenis_hewan) }}" 
                                       placeholder="Masukkan nama jenis hewan"
                                       required>
                                @error('nama_jenis_hewan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- FOOTER: Menggunakan Inline CSS -->
                        <div class="card-footer" style="background-color: white; padding: 15px;">
                            <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                                <a href="{{ route('admin.jenis-hewan.index') }}" class="btn btn-secondary">
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