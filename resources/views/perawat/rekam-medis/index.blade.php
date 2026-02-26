@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Asesmen Pasien</h3></div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- FILTER CARD --}}
        <div class="card mb-4">
            <div class="card-body py-3">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Filter Bulan (Riwayat)</label>
                        <input type="month" name="bulan" class="form-control" value="{{ $bulan }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Filter Tanggal Spesifik</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
                        <small class="text-muted">Kosongkan jika ingin lihat per bulan.</small>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter"></i> Terapkan</button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABEL 1: Antrian Pasien Baru (Selalu Hari Ini jika tidak ada tanggal spesifik) --}}
        @if(!$tanggal || $tanggal == date('Y-m-d'))
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-person-plus-fill me-1"></i> 
                    Antrian Pasien Hari Ini (Belum diperiksa Perawat)
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jam</th>
                            <th>Pasien (Pet)</th>
                            <th>Pemilik</th>
                            <th>Dokter Tujuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($antrian as $row)
                        <tr>
                            <td class="fw-bold text-center">{{ $row->no_urut }}</td>
                            <td>{{ \Carbon\Carbon::parse($row->waktu_daftar)->format('H:i') }}</td>
                            <td>{{ $row->nama_pet }}</td>
                            <td>{{ $row->nama_pemilik }}</td>
                            <td>{{ $row->nama_dokter ?? '-' }}</td>
                            <td>
                                <a href="{{ route('perawat.rekam-medis.create', ['idReservasi' => $row->idreservasi_dokter, 'idPet' => $row->idpet]) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-clipboard-plus"></i> Isi Asesmen
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">Tidak ada antrian baru hari ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- TABEL 2: History (Berdasarkan Filter Bulan/Tanggal) --}}
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="bi bi-check-circle me-1"></i> 
                    Riwayat Rekam Medis ({{ $tanggal ? \Carbon\Carbon::parse($tanggal)->format('d M Y') : \Carbon\Carbon::parse($bulan)->format('F Y') }})
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pet</th>
                            <th>Pemilik</th>
                            <th>Anamnesa</th>
                            <th>Status</th>
                            <th style="width: 150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $row)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y H:i') }}</td>
                            <td>{{ $row->nama_pet }}</td>
                            <td>{{ $row->nama_pemilik }}</td>
                            <td>{{ Str::limit($row->anamnesa, 40) }}</td>
                            <td>
                                @if($row->status_kunjungan == '0')
                                    <span class="badge bg-warning text-dark">Proses Dokter</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('perawat.rekam-medis.show', $row->idrekam_medis) }}" class="btn btn-sm btn-info text-white" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($row->status_kunjungan == '0')
                                    <a href="{{ route('perawat.rekam-medis.edit', $row->idrekam_medis) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('perawat.rekam-medis.delete', $row->idrekam_medis) }}" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">Belum ada data pada periode ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection