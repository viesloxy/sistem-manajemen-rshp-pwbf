@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Riwayat Kesehatan (Rekam Medis)</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card card-success card-outline">
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Dokter</th>
                            <th>Diagnosa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekamMedis as $rm)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($rm->created_at)->format('d/m/Y') }}</td>
                            <td class="fw-bold">{{ $rm->nama_pet }}</td>
                            <td>{{ $rm->nama_dokter }}</td>
                            <td>{{ Str::limit($rm->diagnosa, 50) }}</td>
                            <td>
                                <a href="{{ route('pemilik.rekammedis.show', $rm->idrekam_medis) }}" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-file-text"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted">Belum ada data rekam medis.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection