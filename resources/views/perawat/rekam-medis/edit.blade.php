@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Asesmen Awal</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.rekam-medis.index') }}">List</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Data</h3>
                    </div>
                    
                    <form action="{{ route('perawat.rekam-medis.update', $rm->idrekam_medis) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            {{-- Info Pasien (Read Only) --}}
                            <div class="alert alert-light border mb-3">
                                <strong>Pasien:</strong> {{ $rm->nama_pet }} <br>
                                <strong>Pemilik:</strong> {{ $rm->nama_pemilik }}
                            </div>

                            <div class="mb-3">
                                <label for="anamnesa" class="form-label">Anamnesa (Keluhan) <span class="text-danger">*</span></label>
                                <textarea name="anamnesa" id="anamnesa" class="form-control" rows="3" required>{{ old('anamnesa', $rm->anamnesa) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="temuan_klinis" class="form-label">Temuan Klinis <span class="text-danger">*</span></label>
                                <textarea name="temuan_klinis" id="temuan_klinis" class="form-control" rows="3" required>{{ old('temuan_klinis', $rm->temuan_klinis) }}</textarea>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="bi bi-save me-1"></i> Update Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection