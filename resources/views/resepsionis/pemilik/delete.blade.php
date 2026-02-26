@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Hapus Data Pemilik</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.pemilik.index') }}">Pemilik</a></li>
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
                            <strong>Apakah Anda yakin ingin menghapus data pemilik ini?</strong>
                            <p class="mb-0 text-danger">Peringatan: Menghapus pemilik akan menghapus akun User login mereka secara permanen!</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Pemilik:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $pemilik->nama }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Email:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $pemilik->email }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $pemilik->alamat }}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer" style="background-color: white; padding: 15px;">
                        <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                            <a href="{{ route('resepsionis.pemilik.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>
                            
                            <form action="{{ route('resepsionis.pemilik.destroy', $pemilik->idpemilik) }}" method="POST" style="margin: 0;">
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