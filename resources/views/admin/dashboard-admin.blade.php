@extends('layouts.lte.main')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Admin</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        
        <!-- WELCOME MESSAGE -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-outline card-primary shadow-sm">
                    <div class="card-body text-center p-5">
                        <h1 class="text-primary mb-3">Halo, {{ session('user_name') }}! 👋</h1>
                        <p class="fs-5 text-muted">
                            Email: <strong>{{ session('user_email') }}</strong>
                        </p>
                        <div class="mt-3">
                            <span class="badge bg-primary fs-6 px-4 py-2 rounded-pill">
                                Role: {{ session('user_role_name') }}
                            </span>
                        </div>
                        <div class="alert alert-light border mt-4 d-inline-block px-5" style="background-color: #f8f9fa;">
                            Selamat datang di halaman dashboard Admin.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- STATISTIC BOXES (Sesuai Gambar: User, Pemilik, Pet, Transaksi) -->
        <div class="row">
            <!-- Total User -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-white shadow-sm border-start border-primary border-4">
                    <div class="inner p-3">
                        <p class="text-muted mb-1">Total User</p>
                        <h3 class="text-primary fw-bold">150</h3>
                    </div>
                    <div class="small-box-icon text-primary opacity-25">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
            
            <!-- Total Pemilik -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-white shadow-sm border-start border-success border-4">
                    <div class="inner p-3">
                        <p class="text-muted mb-1">Total Pemilik</p>
                        <h3 class="text-success fw-bold">320</h3>
                    </div>
                    <div class="small-box-icon text-success opacity-25">
                        <i class="bi bi-person-video2"></i>
                    </div>
                </div>
            </div>

            <!-- Total Pet -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-white shadow-sm border-start border-warning border-4">
                    <div class="inner p-3">
                        <p class="text-muted mb-1">Total Pet</p>
                        <!-- Warna ungu sesuai screenshot Anda -->
                        <h3 class="fw-bold" style="color: #8e44ad;">450</h3>
                    </div>
                    <div class="small-box-icon opacity-25" style="color: #8e44ad;">
                        <i class="bi bi-tencent-qq"></i>
                    </div>
                </div>
            </div>

            <!-- Total Transaksi -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-white shadow-sm border-start border-danger border-4">
                    <div class="inner p-3">
                        <p class="text-muted mb-1">Total Transaksi</p>
                        <h3 class="text-danger fw-bold">89</h3>
                    </div>
                    <div class="small-box-icon text-danger opacity-25">
                        <i class="bi bi-receipt"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
</div>
@endsection

{{-- Tidak perlu section scripts chart lagi karena sudah dihapus --}}