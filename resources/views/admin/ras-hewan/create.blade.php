@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tambah Ras Hewan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.ras-hewan.index') }}">Ras Hewan</a></li>
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
                        <h3 class="card-title">Form Tambah Ras Hewan</h3>
                    </div>
                    
                    <form action="{{ route('admin.ras-hewan.store') }}" method="POST">
                        @csrf
                        
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- NAMA RAS -->
                            <div class="mb-3">
                                <label for="nama_ras" class="form-label">Nama Ras <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nama_ras') is-invalid @enderror" 
                                       id="nama_ras" 
                                       name="nama_ras" 
                                       value="{{ old('nama_ras') }}" 
                                       placeholder="Masukkan nama ras (cth: Golden Retriever)"
                                       required>
                                @error('nama_ras')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- JENIS HEWAN (Dropdown) -->
                            <div class="mb-3">
                                <label for="idjenis_hewan" class="form-label">Jenis Hewan <span class="text-danger">*</span></label>
                                <select class="form-control @error('idjenis_hewan') is-invalid @enderror" 
                                        id="idjenis_hewan" 
                                        name="idjenis_hewan" 
                                        required>
                                    <option value="">-- Pilih Jenis Hewan --</option>
                                    @foreach ($jenisHewans as $jenis)
                                        <option value="{{ $jenis->idjenis_hewan }}" {{ old('idjenis_hewan') == $jenis->idjenis_hewan ? 'selected' : '' }}>
                                            {{ $jenis->nama_jenis_hewan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('idjenis_hewan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- FOOTER FIXED: Inline CSS -->
                        <div class="card-footer" style="background-color: white; padding: 15px;">
                            <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                                <a href="{{ route('admin.ras-hewan.index') }}" class="btn btn-secondary">
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