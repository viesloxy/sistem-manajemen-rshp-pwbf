{{-- resources/views/resepsionis/dashboard-resepsionis.blade.php --}}
@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Dashboard Resepsionis</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Resepsionis</li>
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
        <div class="card card-outline card-warning shadow-sm">
          <div class="card-body text-center p-4">
            <h2 class="mb-1">Selamat datang, {{ session('user_name') }}!</h2>
            <p class="text-muted mb-2">Anda login sebagai <strong>{{ session('user_role_name') }}</strong></p>
            <div class="badge bg-warning text-dark px-3 py-2">Resepsionis</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats -->
    <div class="row">

      <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border-start border-warning border-4">
          <div class="inner p-3">
            <p class="text-muted mb-1">Registrasi Pemilik Hari Ini</p>
            <h3 class="text-warning fw-bold">{{ $ownerRegistrationsToday ?? 0 }}</h3>
          </div>
          <div class="small-box-icon text-warning opacity-25">
            <i class="bi bi-person-plus-fill"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border-start border-primary border-4">
          <div class="inner p-3">
            <p class="text-muted mb-1">Registrasi Pet Hari Ini</p>
            <h3 class="text-primary fw-bold">{{ $petRegistrationsToday ?? 0 }}</h3>
          </div>
          <div class="small-box-icon text-primary opacity-25">
            <i class="bi bi-paw-fill"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border-start border-success border-4">
          <div class="inner p-3">
            <p class="text-muted mb-1">Total Antrian</p>
            <h3 class="text-success fw-bold">{{ $queueTotal ?? 0 }}</h3>
          </div>
          <div class="small-box-icon text-success opacity-25">
            <i class="bi bi-list-ol"></i>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border-start border-danger border-4">
          <div class="inner p-3">
            <p class="text-muted mb-1">Temu Dokter Hari Ini</p>
            <h3 class="text-danger fw-bold">{{ $appointmentsToday ?? 0 }}</h3>
          </div>
          <div class="small-box-icon text-danger opacity-25">
            <i class="bi bi-calendar-heart-fill"></i>
          </div>
        </div>
      </div>

    </div>

  </div>
</div>
@endsection