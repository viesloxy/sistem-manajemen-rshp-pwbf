@extends('layouts.lte.main')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Pet</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Pet</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                
                {{-- Alert Success/Error --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Data Pet</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.pet.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-lg"></i> Tambah Pet
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">ID</th>
                                        <th>Nama Pet</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Usia</th>
                                        <th>Jenis/Ras</th>
                                        <th>Pemilik</th>
                                        <th>Warna/Tanda</th>
                                        <th style="width: 200px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pet as $index => $item)
                                    <tr>
                                        <td>{{ $item->idpet }}</td>
                                        <td>{{ $item->nama }}</td>
                                        
                                        {{-- Memanggil Accessor dari Model (Manual via Controller Query Builder) --}}
                                        <td>{{ $item->jenis_kelamin_text }}</td> 
                                        <td>{{ $item->usia }}</td> 

                                        {{-- Mengambil dari nested relationship (Manual via Controller) --}}
                                        <td>
                                            {{ $item->rasHewan->jenisHewan->nama_jenis_hewan ?? 'N/A' }} / 
                                            {{ $item->rasHewan->nama_ras ?? 'N/A' }}
                                        </td>

                                        <td>{{ $item->pemilik->user->nama ?? 'N/A' }}</td>

                                        <td>{{ $item->warna_tanda }}</td>
                                        <td>
                                            <a href="{{ route('admin.pet.edit', $item->idpet) }}" class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <a href="{{ route('admin.pet.delete', $item->idpet) }}" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data pet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <!-- CARD FOOTER: PAGINATION -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-end">
                            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</div>
@endsection