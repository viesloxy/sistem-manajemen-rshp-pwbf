@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Buat Janji Temu</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Daftar</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-calendar-plus me-1"></i> Form Pendaftaran Pasien</h3>
            </div>
            
            <form action="{{ route('resepsionis.temu-dokter.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- 1. Input Tanggal Pendaftaran --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tanggal Pendaftaran <span class="text-danger">*</span></label>
                        <input type="date" 
                               name="tanggal_pendaftaran" 
                               class="form-control" 
                               value="{{ old('tanggal_pendaftaran', date('Y-m-d')) }}" 
                               required>
                        <div class="form-text text-muted">
                            <i class="bi bi-info-circle"></i> Tentukan tanggal kunjungan (Default: Hari ini).
                        </div>
                    </div>

                    {{-- 2. Pilih Pasien --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Pilih Pasien (Hewan) <span class="text-danger">*</span></label>
                        <select name="idpet" class="form-select select2" required>
                            <option value="">-- Cari Nama Hewan / Pemilik --</option>
                            @foreach($pets as $p)
                                <option value="{{ $p->idpet }}">
                                    {{ $p->nama_pet }} (Pemilik: {{ $p->nama_pemilik }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">
                            Hewan belum terdaftar? <a href="{{ route('resepsionis.pet.create') }}" class="text-primary fw-bold">Registrasi Disini</a>
                        </div>
                    </div>

                    {{-- 3. Pilih Dokter --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Pilih Dokter <span class="text-danger">*</span></label>
                        <select name="idrole_user" class="form-select" required>
                            <option value="">-- Pilih Dokter --</option>
                            @foreach($dokters as $d)
                                <option value="{{ $d->idrole_user }}">
                                    drh. {{ $d->nama }} ({{ $d->bidang_dokter ?? 'Umum' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="card-footer" style="background-color: white; padding: 15px;">
                    <div style="display: flex; justify-content: space-between;">
                        <a href="{{ route('resepsionis.temu-dokter.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Proses Pendaftaran
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection