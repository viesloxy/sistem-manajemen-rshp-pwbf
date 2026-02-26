@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Daftar Hewan Peliharaan</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jenis / Ras</th>
                            <th>Kelamin</th>
                            <th>Warna</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pets as $pet)
                        <tr>
                            <td class="fw-bold">{{ $pet->nama }}</td>
                            <td>{{ $pet->nama_jenis_hewan }} - {{ $pet->nama_ras }}</td>
                            <td>{{ $pet->jenis_kelamin == 'J' ? 'Jantan' : 'Betina' }}</td>
                            <td>{{ $pet->warna_tanda }}</td>
                            <td>
                                <a href="{{ route('pemilik.pet.show', $pet->idpet) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-file-medical"></i> Riwayat Medis
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted">Data kosong.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection