@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Hapus Data Pet</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.pet.index') }}">Pet</a></li>
                    <li class="breadcrumb-item active">Hapus</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-trash me-1"></i> Konfirmasi Hapus Data</h3>
                    </div>
                    
                    <div class="card-body">
                        <div class="alert alert-warning text-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill d-block fs-1 mb-2"></i>
                            <strong>Apakah Anda yakin ingin menghapus data hewan ini?</strong>
                            <p class="mb-0">Data yang dihapus tidak dapat dikembalikan.</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Hewan:</label>
                                <div class="form-control-plaintext border rounded px-3 bg-light">
                                    {{ $pet->nama }}
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Pemilik:</label>
                                <div class="form-control-plaintext border rounded px-3 bg-light">
                                    {{ $pet->nama_pemilik }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis / Ras:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $pet->nama_jenis_hewan }} - {{ $pet->nama_ras }}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer" style="background-color: white; padding: 15px;">
                        <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                            <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>
                            
                            <form action="{{ route('resepsionis.pet.destroy', $pet->idpet) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash me-1"></i> Ya, Hapus Data
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection