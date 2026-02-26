@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3>Detail: {{ $pet->nama }}</h3></div>
            <div class="col-sm-6 text-end">
                <a href="{{ route('pemilik.pet.list') }}" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <strong><i class="bi bi-paw me-1"></i> Jenis</strong>
                        <p class="text-muted">{{ $pet->nama_jenis_hewan }} - {{ $pet->nama_ras }}</p>
                        <hr>
                        <strong><i class="bi bi-gender-ambiguous me-1"></i> Kelamin</strong>
                        <p class="text-muted">{{ $pet->jenis_kelamin == 'J' ? 'Jantan' : 'Betina' }}</p>
                        <hr>
                        <strong><i class="bi bi-palette me-1"></i> Warna</strong>
                        <p class="text-muted">{{ $pet->warna_tanda }}</p>
                        <hr>
                        <strong><i class="bi bi-calendar me-1"></i> Lahir</strong>
                        <p class="text-muted">{{ $pet->tanggal_lahir ? \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d M Y') : '-' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header p-2">
                        <h3 class="card-title p-1">Riwayat Kesehatan</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Dokter</th>
                                    <th>Diagnosa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $r)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d M Y') }}</td>
                                    <td>{{ $r->nama_dokter }}</td>
                                    <td>{{ Str::limit($r->diagnosa, 40) }}</td>
                                    <td>
                                        <a href="{{ route('pemilik.rekammedis.show', $r->idrekam_medis) }}" class="btn btn-xs btn-info text-white">Lihat</a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted">Belum ada riwayat medis.</td></tr>
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