@extends('layouts.lte.main')

@section('content')
<div class="app-content">
    <div class="container-fluid pt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Asesmen Awal Perawat</h3>
                    </div>
                    <form action="{{ route('perawat.rekam-medis.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="idreservasi" value="{{ $info->idreservasi_dokter }}">

                        <div class="card-body">
                            {{-- Info Pasien Static --}}
                            <div class="alert alert-light border">
                                <strong>Pasien:</strong> {{ $info->nama_pet }} <br>
                                <strong>Pemilik:</strong> {{ $info->nama_pemilik }}
                            </div>

                            <div class="mb-3">
                                <label>Dokter Pemeriksa <span class="text-danger">*</span></label>
                                <select name="dokter_pemeriksa" class="form-select" required>
                                    @foreach($dokters as $d)
                                        <option value="{{ $d->idrole_user }}" {{ $d->idrole_user == $info->id_dokter_tujuan ? 'selected' : '' }}>
                                            {{ $d->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Anamnesa (Keluhan Utama) <span class="text-danger">*</span></label>
                                <textarea name="anamnesa" class="form-control" rows="3" placeholder="Contoh: Muntah 3x sejak pagi, tidak mau makan..." required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Temuan Klinis Awal <span class="text-danger">*</span></label>
                                <textarea name="temuan_klinis" class="form-control" rows="3" placeholder="Contoh: Berat Badan: 5kg, Suhu: 39C, Membran mukosa pucat..." required></textarea>
                                <small class="text-muted">Isi data vital sign (BB, Suhu, Tensi, dll) di sini.</small>
                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('perawat.rekam-medis.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Asesmen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection