@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Pemilik</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pemilik</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        
        <!-- Welcome Card (Sama seperti Dokter) -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-outline card-dark shadow-sm">
                    <div class="card-body text-center p-4">
                        {{-- Menggunakan Auth user name sebagai fallback jika session user_name tidak ada --}}
                        <h2 class="mb-1">Selamat datang, {{ session('user_name') ?? Auth::user()->name }}!</h2>
                        <p class="text-muted mb-2">Anda login sebagai <strong>Pemilik Hewan</strong></p>
                        <div class="badge bg-dark px-3 py-2">Pemilik</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATS (Style Modern: Bg-white + Shadow + Border Start) --}}
        <div class="row">
            
            <!-- Hewan Peliharaan -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-white shadow-sm border-start border-info border-4">
                    <div class="inner p-3">
                        <p class="text-muted mb-1">Hewan Peliharaan</p>
                        <h3 class="text-info fw-bold">{{ $totalPet }}</h3>
                        
                        <a href="{{ route('pemilik.pet.list') }}" class="text-decoration-none small text-muted mt-2 d-inline-block">
                            Lihat Detail <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="small-box-icon text-info opacity-25"><i class="bi bi-paw"></i></div>
                </div>
            </div>

            <!-- Jadwal Aktif -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-white shadow-sm border-start border-warning border-4">
                    <div class="inner p-3">
                        <p class="text-muted mb-1">Jadwal Aktif</p>
                        <h3 class="text-warning fw-bold">{{ $reservasiAktif }}</h3>
                        
                        <a href="{{ route('pemilik.temu-dokter.list') }}" class="text-decoration-none small text-muted mt-2 d-inline-block">
                            Lihat Jadwal <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="small-box-icon text-warning opacity-25"><i class="bi bi-calendar-event"></i></div>
                </div>
            </div>

            <!-- Riwayat Medis -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-white shadow-sm border-start border-success border-4">
                    <div class="inner p-3">
                        <p class="text-muted mb-1">Riwayat Medis</p>
                        <h3 class="text-success fw-bold">{{ $totalRekamMedis }}</h3>
                        
                        <a href="{{ route('pemilik.rekammedis.list') }}" class="text-decoration-none small text-muted mt-2 d-inline-block">
                            Lihat History <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="small-box-icon text-success opacity-25"><i class="bi bi-file-medical"></i></div>
                </div>
            </div>

            <!-- Kunjungan Terakhir -->
            <div class="col-lg-3 col-6">
                {{-- Menggunakan warna ungu custom seperti dashboard dokter agar konsisten untuk penanda waktu --}}
                <div class="small-box bg-white shadow-sm border-start border-4" style="border-color: #8e44ad;">
                    <div class="inner p-3">
                        <p class="text-muted mb-1">Kunjungan Terakhir</p>
                        <h3 class="fw-bold" style="color: #8e44ad; font-size: 1.4rem;">{{ $lastVisitDate }}</h3>
                        <span class="small text-muted mt-2 d-inline-block">Cek detail di History</span>
                    </div>
                    <div class="small-box-icon opacity-25" style="color: #8e44ad;"><i class="bi bi-clock-history"></i></div>
                </div>
            </div>
        </div>

        {{-- LIST PET (Tabel) --}}
        <div class="row mt-2">
            <div class="col-12">
                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-header bg-white">
                        <h3 class="card-title fw-bold text-dark"><i class="bi bi-list-ul me-2"></i>Daftar Hewan Peliharaan</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i class="bi bi-dash-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pets as $pet)
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">{{ $pet->nama }}</td>
                                    <td>
                                        @if($pet->jenis_kelamin == 'J')
                                            <span class="badge bg-primary bg-opacity-10 text-primary">Jantan</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger">Betina</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="bi bi-calendar3 me-1 text-muted"></i> 
                                        {{ $pet->tanggal_lahir ? \Carbon\Carbon::parse($pet->tanggal_lahir)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('pemilik.pet.show', $pet->idpet) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-box-seam display-6 d-block mb-2"></i>
                                        Belum ada hewan terdaftar.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white text-end">
                        <a href="{{ route('pemilik.pet.list') }}" class="btn btn-primary btn-sm">Lihat Semua Hewan</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection