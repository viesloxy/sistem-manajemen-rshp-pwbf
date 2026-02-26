@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Hapus Rekam Medis</h3></div>
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
                            <strong>Apakah Anda yakin ingin menghapus data ini?</strong>
                            <p class="mb-0">Tindakan ini tidak dapat dibatalkan.</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Periksa:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ \Carbon\Carbon::parse($rm->created_at)->format('d F Y H:i') }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pasien:</label>
                            <div class="form-control-plaintext border rounded px-3 bg-light">
                                {{ $rm->nama_pet }} ({{ $rm->nama_pemilik }})
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between">
                        <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </a>
                        
                        <form action="{{ route('perawat.rekam-medis.destroy', $rm->idrekam_medis) }}" method="POST">
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
@endsection