@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Hapus Kategori Klinis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.kategori-klinis.index') }}">Kategori Klinis</a></li>
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
                            <strong>Apakah Anda yakin ingin menghapus kategori klinis ini?</strong>
                            <p class="mb-0">Data 'Kode Tindakan Terapi' yang terkait mungkin akan terpengaruh.</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">ID Kategori Klinis:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $kategoriKlinis->idkategori_klinis }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Kategori Klinis:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $kategoriKlinis->nama_kategori_klinis }}
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER: Tombol Kiri-Kanan -->
                    <div class="card-footer" style="background-color: white; padding: 15px;">
                        <div style="display: flex; justify-content: space-between; width: 100%; align-items: center;">
                            <a href="{{ route('admin.kategori-klinis.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </a>
                            
                            <form action="{{ route('admin.kategori-klinis.destroy', $kategoriKlinis->idkategori_klinis) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash me-1"></i> Ya, Hapus Kategori Klinis
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