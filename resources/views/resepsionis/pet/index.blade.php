@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Hewan (Pet)</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Pet</li>
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
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">List Pasien Hewan</h3>
                        <div class="card-tools">
                            <a href="{{ route('resepsionis.pet.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg"></i> Tambah Pet
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Nama Pet</th>
                                    <th>Pemilik</th>
                                    <th>Jenis / Ras</th>
                                    <th>Kelamin</th>
                                    <th>Warna</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pets as $index => $pet)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pet->nama }}</td>
                                    <td>{{ $pet->nama_pemilik }}</td>
                                    <td>{{ $pet->nama_jenis_hewan }} - {{ $pet->nama_ras }}</td>
                                    <td>
                                        @if($pet->jenis_kelamin == 'J') 
                                            <span class="badge bg-primary">Jantan</span>
                                        @else 
                                            <span class="badge bg-danger">Betina</span>
                                        @endif
                                    </td>
                                    <td>{{ $pet->warna_tanda ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('resepsionis.pet.edit', $pet->idpet) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                        
                                        {{-- PERBAIKAN: Gunakan Link ke Route Delete (GET) --}}
                                        <a href="{{ route('resepsionis.pet.delete', $pet->idpet) }}" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center">Belum ada data pet.</td></tr>
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