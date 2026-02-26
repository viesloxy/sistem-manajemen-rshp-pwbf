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
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.pet.index') }}">Data Pet</a></li>
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
                            <strong>Apakah Anda yakin ingin menghapus data pet ini secara permanen?</strong>
                            <p class="mb-0">Data rekam medis yang terkait mungkin akan terpengaruh.</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Pet:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $pet->nama }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pemilik:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $pet->pemilik->user->nama ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis/Ras:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $pet->rasHewan->jenisHewan->nama_jenis_hewan ?? 'N/A' }} / 
                                {{ $pet->rasHewan->nama_ras ?? 'N/A' }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Usia:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $pet->usia }}
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER FIXED: Tombol Kiri-Kanan -->
                    <div class="card-footer" style="background-color: white; padding: 15px;">
                        <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                            <a href="{{ route('admin.pet.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>
                            
                            <form action="{{ route('admin.pet.destroy', $pet->idpet) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash me-1"></i> Ya, Hapus Pet
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