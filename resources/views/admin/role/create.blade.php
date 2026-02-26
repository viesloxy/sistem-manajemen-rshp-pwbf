@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tambah Role Baru</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">Data Role</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Form Tambah Role</h3>
                    </div>
                    
                    <form action="{{ route('admin.role.store') }}" method="POST">
                        @csrf
                        
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="nama_role" class="form-label">Nama Role <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nama_role') is-invalid @enderror" 
                                       id="nama_role" 
                                       name="nama_role" 
                                       value="{{ old('nama_role') }}" 
                                       placeholder="Masukkan nama role (cth: Resepsionis)"
                                       required>
                                @error('nama_role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- FOOTER FIXED: Inline CSS -->
                        <div class="card-footer" style="background-color: white; padding: 15px;">
                            <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                                <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Simpan
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