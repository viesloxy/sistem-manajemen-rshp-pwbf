@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Hapus Profil Pemilik</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.pemilik.index') }}">Data Pemilik</a></li>
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
                        <h3 class="card-title">Konfirmasi Hapus Data</h3>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-warning text-center">
                            <i class="bi bi-exclamation-triangle-fill d-block fs-1 mb-2"></i>
                            <strong>Apakah Anda yakin ingin menghapus profil pemilik ini?</strong>
                            <p class="mb-0">Aksi ini akan menghapus data pemilik & akun user terkait.</p>
                        </div>

                        <!-- NAMA -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Pemilik</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $pemilik->nama }}
                            </div>
                        </div>

                        <!-- EMAIL -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $pemilik->email }}
                            </div>
                        </div>

                        <!-- NO WA -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">No. WhatsApp</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $pemilik->no_wa ?? '-' }}
                            </div>
                        </div>

                        <!-- ALAMAT -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $pemilik->alamat ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pemilik.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>

                            <form action="{{ route('admin.pemilik.destroy', $pemilik->idpemilik) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash me-1"></i> Ya, Hapus
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
