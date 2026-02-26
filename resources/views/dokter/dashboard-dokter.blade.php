{{-- resources/views/dokter/dashboard-dokter.blade.php --}}
@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Dashboard Dokter</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Dokter</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">

    <!-- Welcome -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card card-outline card-dark shadow-sm">
          <div class="card-body text-center p-4">
            <h2 class="mb-1">Selamat datang, Dr. {{ session('user_name') }}!</h2>
            <p class="text-muted mb-2">Anda login sebagai <strong>{{ session('user_role_name') }}</strong></p>
            <div class="badge bg-dark px-3 py-2">Dokter</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border-start border-dark border-4">
          <div class="inner p-3">
            <p class="text-muted mb-1">Pasien Hari Ini</p>
            <h3 class="text-dark fw-bold">{{ $patientsToday ?? 0 }}</h3>
          </div>
          <div class="small-box-icon text-dark opacity-25"><i class="bi bi-person-lines-fill"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border-start border-primary border-4">
          <div class="inner p-3">
            <p class="text-muted mb-1">Antrian</p>
            <h3 class="text-primary fw-bold">{{ $queueCount ?? 0 }}</h3>
          </div>
          <div class="small-box-icon text-primary opacity-25"><i class="bi bi-list-task"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border-start border-success border-4">
          <div class="inner p-3">
            <p class="text-muted mb-1">Rekam Medis Hari Ini</p>
            <h3 class="text-success fw-bold">{{ $recordsToday ?? 0 }}</h3>
          </div>
          <div class="small-box-icon text-success opacity-25"><i class="bi bi-journal-medical"></i></div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border-start border-warning border-4">
          <div class="inner p-3">
            <p class="text-muted mb-1">Janji Berikutnya</p>
            <h3 class="fw-bold" style="color: #8e44ad;">{{ $nextAppointment ?? '—' }}</h3>
          </div>
          <div class="small-box-icon opacity-25" style="color: #8e44ad;"><i class="bi bi-calendar-event"></i></div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
