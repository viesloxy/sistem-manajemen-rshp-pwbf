@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Detail Rekam Medis</h3></div>
            <div class="col-sm-6 text-end">
                <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            {{-- DATA PASIEN & ASESMEN --}}
            <div class="col-md-6">
                <div class="card card-primary card-outline h-100">
                    <div class="card-header">
                        <h3 class="card-title">Data Pasien & Asesmen Awal</h3>
                        <div class="card-tools">
                            <a href="{{ route('perawat.rekam-medis.edit', $header->idrekam_medis) }}" class="btn btn-tool" title="Edit Asesmen">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Pasien</dt> <dd class="col-sm-8">{{ $header->nama_pet }}</dd>
                            <dt class="col-sm-4">Pemilik</dt> <dd class="col-sm-8">{{ $header->nama_pemilik }}</dd>
                            <dt class="col-sm-4">Dokter</dt> <dd class="col-sm-8">{{ $header->nama_dokter }}</dd>
                        </dl>
                        <hr>
                        <div class="mb-3">
                            <label class="fw-bold text-primary">Anamnesa (Keluhan)</label>
                            <div class="p-2 bg-light border rounded">{{ $header->anamnesa }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold text-primary">Temuan Klinis (Tanda Vital)</label>
                            <div class="p-2 bg-light border rounded">{{ $header->temuan_klinis }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DIAGNOSA & TINDAKAN (READ ONLY BAGI PERAWAT) --}}
            <div class="col-md-6">
                <div class="card card-success card-outline h-100">
                    <div class="card-header">
                        <h3 class="card-title">Diagnosa & Tindakan (Oleh Dokter)</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="fw-bold text-success">Diagnosa Dokter</label>
                            <div class="p-2 bg-light border rounded">
                                @if($header->diagnosa)
                                    {{ $header->diagnosa }}
                                @else
                                    <span class="text-muted fst-italic">Belum diisi dokter</span>
                                @endif
                            </div>
                        </div>

                        <label class="fw-bold text-success">Tindakan / Resep</label>
                        <table class="table table-sm table-bordered mt-1">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Tindakan</th>
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
                                <tr><td colspan="3" class="text-center text-muted small">Belum ada tindakan</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection