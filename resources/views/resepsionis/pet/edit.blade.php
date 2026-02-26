@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Pet</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.pet.index') }}">Pet</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Edit Data Hewan</h3>
            </div>
            <form action="{{ route('resepsionis.pet.update', $pet->idpet) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="mb-3">
                        <label>Pemilik <span class="text-danger">*</span></label>
                        <select name="idpemilik" class="form-select" required>
                            @foreach($pemiliks as $p)
                                <option value="{{ $p->idpemilik }}" {{ $pet->idpemilik == $p->idpemilik ? 'selected' : '' }}>
                                    {{ $p->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Nama Hewan <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" required value="{{ $pet->nama }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Jenis & Ras</label>
                            <select name="idras_hewan" class="form-select" required>
                                @foreach($rasHewan as $r)
                                    <option value="{{ $r->idras_hewan }}" {{ $pet->idras_hewan == $r->idras_hewan ? 'selected' : '' }}>
                                        {{ $r->nama_jenis_hewan }} - {{ $r->nama_ras }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="J" {{ $pet->jenis_kelamin == 'J' ? 'selected' : '' }}>Jantan</option>
                                <option value="B" {{ $pet->jenis_kelamin == 'B' ? 'selected' : '' }}>Betina</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ $pet->tanggal_lahir }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Warna / Tanda</label>
                            <input type="text" name="warna_tanda" class="form-control" value="{{ $pet->warna_tanda }}">
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="background-color: white; padding: 15px;">
                    <div style="display: flex; justify-content: space-between;">
                        <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                        <button type="submit" class="btn btn-warning text-white"><i class="bi bi-save"></i> Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection