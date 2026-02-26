@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6"><h3 class="mb-0">Detail Rekam Medis #{{ $header->idrekam_medis }}</h3></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.rekam-medis.index') }}">List</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            {{-- KIRI: DATA PEMERIKSAAN --}}
            <div class="col-md-5">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Data Pemeriksaan</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-bs-toggle="collapse" data-bs-target="#formHeader">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Pasien</dt> <dd class="col-sm-8">{{ $header->nama_pet }}</dd>
                            <dt class="col-sm-4">Pemilik</dt> <dd class="col-sm-8">{{ $header->nama_pemilik }}</dd>
                            <dt class="col-sm-4">Dokter</dt> <dd class="col-sm-8">{{ $header->nama_dokter }}</dd>
                            <hr class="my-2">
                            <dt class="col-12">Anamnesa</dt> 
                            <dd class="col-12 bg-light p-2 rounded mb-2">{{ $header->anamnesa ?? '-' }}</dd>
                            
                            <dt class="col-12">Temuan Klinis</dt>
                            <dd class="col-12 bg-light p-2 rounded mb-2">{{ $header->temuan_klinis ?? '-' }}</dd>
                            
                            <dt class="col-12">Diagnosa</dt>
                            <dd class="col-12 bg-light p-2 rounded">{{ $header->diagnosa ?? '-' }}</dd>
                        </dl>

                        {{-- Form Edit Header (Hidden by default) --}}
                        <div class="collapse mt-3" id="formHeader">
                            <form action="{{ route('perawat.rekam-medis.update-header', $header->idrekam_medis) }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <label class="form-label text-sm">Anamnesa</label>
                                    <textarea name="anamnesa" class="form-control form-control-sm" rows="2">{{ $header->anamnesa }}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label text-sm">Temuan Klinis</label>
                                    <textarea name="temuan_klinis" class="form-control form-control-sm" rows="2">{{ $header->temuan_klinis }}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label text-sm">Diagnosa</label>
                                    <textarea name="diagnosa" class="form-control form-control-sm" rows="2">{{ $header->diagnosa }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KANAN: LIST TINDAKAN --}}
            <div class="col-md-7">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Tindakan & Terapi</h3>
                    </div>
                    <div class="card-body">
                        
                        {{-- Form Tambah Tindakan --}}
                        <form action="{{ route('perawat.rekam-medis.create-detail', $header->idrekam_medis) }}" method="POST" class="row g-2 mb-4 bg-light p-3 rounded">
                            @csrf
                            <div class="col-md-6">
                                <select name="idkode_tindakan_terapi" class="form-select select2" required>
                                    <option value="">-- Pilih Tindakan --</option>
                                    @foreach($listKode as $kode)
                                        <option value="{{ $kode->idkode_tindakan_terapi }}">{{ $kode->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="detail" class="form-control" placeholder="Catatan tambahan...">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success w-100"><i class="bi bi-plus-lg"></i></button>
                            </div>
                        </form>

                        {{-- Tabel List Tindakan --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Tindakan</th>
                                        <th>Kategori</th>
                                        <th>Catatan</th>
                                        <th style="width: 50px">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($detailTindakan as $row)
                                    <tr>
                                        <td>{{ $row->kode }}</td>
                                        <td>{{ $row->deskripsi_tindakan_terapi }}</td>
                                        <td>{{ $row->nama_kategori }}</td>
                                        <td>{{ $row->detail }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('perawat.rekam-medis.delete-detail', ['id' => $header->idrekam_medis, 'idDetail' => $row->iddetail_rekam_medis]) }}" method="POST" onsubmit="return confirm('Hapus tindakan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center text-muted">Belum ada tindakan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection