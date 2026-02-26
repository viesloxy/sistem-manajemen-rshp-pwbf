@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Jadwal Temu Dokter</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        {{-- Form Buat Janji Baru (Card Collapse atau Modal) --}}
        <div class="card card-primary card-outline mb-4 collapsed-card">
            <div class="card-header">
                <h3 class="card-title"><i class="bi bi-calendar-plus me-1"></i> Buat Janji Temu Baru</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
                <form action="{{ route('pemilik.temu-dokter.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Pilih Hewan</label>
                            <select name="idpet" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->idpet }}">{{ $pet->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Kunjungan</label>
                            <input type="date" name="tanggal_kunjungan" class="form-control" min="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Buat Jadwal</button>
                </form>
            </div>
        </div>

        {{-- Tabel List --}}
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Tgl Kunjungan</th>
                            <th>No Antrian</th>
                            <th>Hewan</th>
                            <th>Dokter</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($temuDokterList as $res)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($res->waktu_daftar)->format('d M Y H:i') }}</td>
                            <td class="fw-bold text-center">#{{ $res->no_urut }}</td>
                            <td>
                                {{ $res->nama_pet }} <br>
                                <small class="text-muted">{{ $res->nama_jenis_hewan }}</small>
                            </td>
                            <td>{{ $res->nama_dokter ?? '-' }}</td>
                            <td>
                                @if($res->status == '0') <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($res->status == '1') <span class="badge bg-success">Selesai</span>
                                @elseif($res->status == '2') <span class="badge bg-danger">Batal</span>
                                @endif
                            </td>
                            <td>
                                @if($res->status == '0')
                                <form action="{{ route('pemilik.temu-dokter.cancel', $res->idreservasi_dokter) }}" method="POST" onsubmit="return confirm('Batalkan jadwal ini?')">
                                    @csrf
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-x-circle"></i> Batal</button>
                                </form>
                                @else
                                <span class="text-muted small">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">Belum ada riwayat temu dokter.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
@endsection