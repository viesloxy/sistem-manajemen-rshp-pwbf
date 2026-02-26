@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">
                    @if($header->status_periksa == '0')
                        <i class="bi bi-stethoscope me-1 text-primary"></i> Pemeriksaan: {{ $header->nama_pet }}
                    @else
                        <i class="bi bi-file-earmark-medical me-1 text-success"></i> Detail Rekam Medis: {{ $header->nama_pet }}
                    @endif
                </h3>
            </div>
            <div class="col-sm-6 text-end">
                <a href="{{ route('dokter.rekam-medis.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        
        @if(session('error')) 
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div> 
        @endif
        @if(session('success')) 
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div> 
        @endif

        <div class="row">
            {{-- KIRI: DATA MEDIS & DIAGNOSA --}}
            <div class="col-md-5">
                <div class="card card-primary card-outline h-100">
                    <div class="card-header"><h5 class="card-title">Data Medis</h5></div>
                    <div class="card-body">
                        
                        {{-- Info Pasien --}}
                        <div class="alert alert-light border mb-3">
                            <small class="text-muted d-block">Pemilik</small>
                            <strong>{{ $header->nama_pemilik }}</strong>
                        </div>

                        {{-- Anamnesa (Read Only) --}}
                        <div class="mb-3">
                            <label class="text-muted small fw-bold">Anamnesa (Perawat)</label>
                            <div class="p-2 bg-light border rounded">{{ $header->anamnesa }}</div>
                        </div>

                        {{-- Form Diagnosa (Bisa diedit kapan saja untuk koreksi) --}}
                        <form action="{{ route('dokter.rekam-medis.update-diagnosa', $header->idrekam_medis) }}" method="POST">
                            @csrf @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label">Temuan Klinis</label>
                                <textarea name="temuan_klinis" class="form-control" rows="4">{{ $header->temuan_klinis }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Diagnosa Akhir</label>
                                <textarea name="diagnosa" class="form-control" rows="3" placeholder="Isi diagnosa..." required>{{ $header->diagnosa }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-sm">
                                <i class="bi bi-save me-1"></i> Simpan Diagnosa / Temuan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- KANAN: TINDAKAN / RESEP --}}
            <div class="col-md-7">
                <div class="card {{ $header->status_periksa == '0' ? 'card-warning' : 'card-success' }} card-outline h-100">
                    <div class="card-header">
                        <h5 class="card-title">
                            Tindakan & Resep 
                            @if($header->status_periksa == '1') <span class="badge bg-success ms-2">Selesai</span> @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        
                        {{-- FORM INPUT (Hanya muncul jika STATUS = 0 / Sedang Periksa) --}}
                        @if($header->status_periksa == '0')
                        <div class="bg-light p-3 border rounded mb-3">
                            <h6 class="text-muted text-sm mb-2 fw-bold">Tambah Tindakan Baru</h6>
                            <form action="{{ route('dokter.rekam-medis.tindakan.store', $header->idrekam_medis) }}" method="POST" class="row g-2">
                                @csrf
                                <div class="col-md-5">
                                    <select name="idkode_tindakan_terapi" class="form-select form-select-sm select2" required>
                                        <option value="">-- Pilih Tindakan --</option>
                                        @foreach($masterTindakan as $t)
                                            <option value="{{ $t->idkode_tindakan_terapi }}">{{ $t->kode }} - {{ $t->deskripsi_tindakan_terapi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" name="detail" class="form-control form-control-sm" placeholder="Detail (Dosis, dll)">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success btn-sm w-100" title="Tambah">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        @else
                            <div class="alert alert-info py-2 text-sm mb-3">
                                <i class="bi bi-info-circle me-1"></i> Pemeriksaan selesai. Anda dapat mengoreksi (edit/hapus) tindakan di bawah ini.
                            </div>
                        @endif

                        {{-- TABEL TINDAKAN --}}
                        <div class="table-responsive">
                            <table class="table table-sm table-striped border align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Tindakan</th>
                                        <th>Detail / Catatan</th>
                                        <th style="width:100px" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tindakan as $row)
                                    <tr>
                                        <td><span class="badge bg-secondary">{{ $row->kode }}</span></td>
                                        <td>{{ $row->deskripsi_tindakan_terapi }}</td>
                                        <td>
                                            {{-- Jika Status Selesai (1), Tampilkan Form Edit Inline sederhana --}}
                                            @if($header->status_periksa == '1')
                                                <form action="{{ route('dokter.rekam-medis.tindakan.update', $row->iddetail_rekam_medis) }}" method="POST" class="d-flex">
                                                    @csrf @method('PUT')
                                                    <input type="text" name="detail" value="{{ $row->detail }}" class="form-control form-control-sm me-1" style="min-width: 100px;">
                                                    <button type="submit" class="btn btn-xs btn-primary" title="Simpan Perubahan"><i class="bi bi-check"></i></button>
                                                </form>
                                            @else
                                                {{ $row->detail }}
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{-- Tombol Delete HANYA MUNCUL jika Status Selesai (1), Sesuai Request --}}
                                            @if($header->status_periksa == '1')
                                                <form action="{{ route('dokter.rekam-medis.tindakan.destroy', $row->iddetail_rekam_medis) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tindakan ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-xs btn-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                                </form>
                                            @else
                                                <span class="text-muted text-xs">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center text-muted small py-3">Belum ada tindakan diinput.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                    
                    {{-- FOOTER: TOMBOL SELESAI --}}
                    @if($header->status_periksa == '0')
                    <div class="card-footer bg-light">
                        <form action="{{ route('dokter.rekam-medis.selesai', $header->idrekam_medis) }}" method="POST" onsubmit="return confirm('Selesaikan pemeriksaan? Status pasien akan berubah menjadi Selesai dan Anda dapat mengedit tindakan setelah ini.')">
                            @csrf
                            <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                                <i class="bi bi-check-circle-fill me-1"></i> SELESAI PEMERIKSAAN
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection