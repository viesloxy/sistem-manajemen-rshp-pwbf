@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Antrian / Temu Dokter</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Antrian</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Kunjungan Hari Ini</h3>
                        <div class="card-tools">
                            <a href="{{ route('resepsionis.temu-dokter.create') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-lg"></i> Buat Janji Temu
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No Urut</th>
                                    <th>Waktu Daftar</th>
                                    <th>Nama Pasien (Pet)</th>
                                    <th>Pemilik</th>
                                    <th>Dokter Tujuan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($antrians as $a)
                                <tr>
                                    <td class="text-center fw-bold">{{ $a->no_urut }}</td>
                                    <td>{{ \Carbon\Carbon::parse($a->waktu_daftar)->format('d M H:i') }}</td>
                                    <td>{{ $a->nama_pet }}</td>
                                    <td>{{ $a->nama_pemilik }}</td>
                                    <td>
                                        drh. {{ $a->nama_dokter }}<br>
                                        <small class="text-muted">{{ $a->bidang_dokter ?? 'Umum' }}</small>
                                    </td>
                                    <td>
                                        @if($a->status == '0')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($a->status == '1')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-secondary">Batal</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center">Belum ada antrian hari ini.</td></tr>
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