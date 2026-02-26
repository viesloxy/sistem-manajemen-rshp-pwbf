@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3>Detail Rekam Medis</h3></div>
            <div class="col-sm-6 text-end">
                <a href="{{ route('pemilik.rekammedis.list') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">
                    <i class="bi bi-file-medical me-1"></i> 
                    {{ $header->nama_pet }} - {{ \Carbon\Carbon::parse($header->created_at)->format('d M Y') }}
                </h3>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>Dokter Pemeriksa:</strong> <br> {{ $header->nama_dokter }}
                    </div>
                    <div class="col-md-6 text-end">
                        <strong>ID RM:</strong> #{{ $header->idrekam_medis }}
                    </div>
                </div>

                <div class="mb-3">
                    <h5 class="text-success border-bottom pb-1">Hasil Pemeriksaan</h5>
                    <dl class="row">
                        <dt class="col-sm-3">Keluhan (Anamnesa)</dt>
                        <dd class="col-sm-9">{{ $header->anamnesa }}</dd>

                        <dt class="col-sm-3">Temuan Klinis</dt>
                        <dd class="col-sm-9">{{ $header->temuan_klinis }}</dd>

                        <dt class="col-sm-3">Diagnosa</dt>
                        <dd class="col-sm-9 fw-bold">{{ $header->diagnosa }}</dd>
                    </dl>
                </div>

                <div>
                    <h5 class="text-success border-bottom pb-1">Tindakan & Obat</h5>
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Kode</th>
                                <th>Nama Tindakan</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tindakan as $t)
                            <tr>
                                <td>{{ $t->kode }}</td>
                                <td>{{ $t->deskripsi_tindakan_terapi }}</td>
                                <td>{{ $t->detail }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center text-muted small">Tidak ada tindakan khusus.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection