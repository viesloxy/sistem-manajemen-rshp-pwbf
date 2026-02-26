@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Daftar Pasien Saya Hari Ini</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Antrian</th>
                            <th>Pasien</th>
                            <th>Pemilik</th>
                            <th>Keluhan (Anamnesa)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasien as $p)
                        <tr class="{{ $p->status_periksa == '1' ? 'bg-light text-muted' : '' }}">
                            <td class="text-center fw-bold">{{ $p->no_urut }}</td>
                            <td>{{ $p->nama_pet }}</td>
                            <td>{{ $p->nama_pemilik }}</td>
                            <td>{{ Str::limit($p->anamnesa, 40) }}</td>
                            <td>
                                @if($p->status_periksa == '0')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dokter.rekam-medis.edit', $p->idrekam_medis) }}" 
                                   class="btn btn-sm {{ $p->status_periksa == '0' ? 'btn-primary' : 'btn-secondary' }}">
                                    <i class="bi bi-stethoscope"></i> {{ $p->status_periksa == '0' ? 'Periksa' : 'Lihat' }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">Tidak ada pasien hari ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection