@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Pemilik</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.pemilik.index') }}">Pemilik</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="bi bi-pencil-square me-1"></i> Edit Data</h3>
                    </div>
                    
                    <form action="{{ route('resepsionis.pemilik.update', $pemilik->idpemilik) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control" required value="{{ old('nama', $pemilik->nama) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" required value="{{ old('email', $pemilik->email) }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Nomor WhatsApp <span class="text-danger">*</span></label>
                                <input type="number" name="no_wa" class="form-control" required value="{{ old('no_wa', $pemilik->no_wa) }}">
                            </div>
                            <div class="mb-3">
                                <label>Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $pemilik->alamat) }}</textarea>
                            </div>
                        </div>

                        <div class="card-footer" style="background-color: white; padding: 15px;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <a href="{{ route('resepsionis.pemilik.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-warning text-white">
                                    <i class="bi bi-save me-1"></i> Update Data
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection