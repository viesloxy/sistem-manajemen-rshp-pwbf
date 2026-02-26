@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Hapus Ras Hewan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.ras-hewan.index') }}">Ras Hewan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Hapus</li>
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
                        <h3 class="card-title">Konfirmasi Hapus Data</h3>
                    </div>
                    
                    <div class="card-body">
                        <div class="alert alert-warning text-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill d-block fs-1 mb-2"></i>
                            <strong>Apakah Anda yakin ingin menghapus data ini?</strong>
                            <p class="mb-0">Tindakan ini tidak dapat dibatalkan.</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Ras:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $rasHewan->nama_ras }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Hewan:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $rasHewan->jenisHewan ? $rasHewan->jenisHewan->nama_jenis_hewan : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER FIXED: Inline CSS -->
                    <div class="card-footer" style="background-color: white; padding: 15px;">
                        <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                            <a href="{{ route('admin.ras-hewan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>
                            
                            <form action="{{ route('admin.ras-hewan.destroy', $rasHewan->idras_hewan) }}" method="POST" style="margin: 0;">
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