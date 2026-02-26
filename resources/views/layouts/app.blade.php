<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Font Awesome (Tambahan agar icon muncul) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        
                        {{-- HANYA TAMPIL JIKA SUDAH LOGIN --}}
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                            </li>

                            {{-- ============================== --}}
                            {{-- === LINK NAVBAR ADMIN === --}}
                            {{-- ============================== --}}
                            @if(session('user_role') == 1)
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownDataMaster" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v_pre>
                                    <i class="fas fa-database"></i> Data Master
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownDataMaster">
                                    {{-- URUTAN SESUAI PERMINTAAN ANDA --}}
                                    <a class="dropdown-item" href="{{ route('admin.user.index') }}">
                                        <i class="fas fa-fw fa-user-edit"></i> Data User
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.role.index') }}">
                                        <i class="fas fa-fw fa-user-tag"></i> Manajemen Role
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('admin.jenis-hewan.index') }}">
                                        <i class="fas fa-fw fa-paw"></i> Jenis Hewan
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.ras-hewan.index') }}">
                                        <i class="fas fa-fw fa-dog"></i> Ras Hewan
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('admin.pemilik.index') }}">
                                        <i class="fas fa-fw fa-users"></i> Data Pemilik
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.pet.index') }}">
                                        <i class="fas fa-fw fa-cat"></i> Data Pet
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('admin.kategori.index') }}">
                                        <i class="fas fa-fw fa-tags"></i> Data Kategori
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.kategori-klinis.index') }}">
                                        <i class="fas fa-fw fa-clinic-medical"></i> Data Kategori Klinis
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.kode-tindakan-terapi.index') }}">
                                        <i class="fas fa-fw fa-notes-medical"></i> Data Kode Tindakan Terapi
                                    </a>
                                </div>
                            </li>
                            @endif
                            {{-- === AKHIR LINK ADMIN === --}}


                            {{-- ========================================== --}}
                            {{-- === LINK NAVBAR BARU (TUGAS D.3) === --}}
                            {{-- ========================================== --}}

                            {{-- Tampil jika role Resepsionis (4) --}}
                            @if(session('user_role') == 4)
                            <li class="nav-item">
                                {{-- DIUBAH: Sesuai file Anda 'registrasi' --}}
                                <a class="nav-link" href="{{ route('resepsionis.registrasi.index') }}">
                                    <i class="fas fa-book-medical"></i> Registrasi
                                </a>
                            </li>
                            @endif

                            {{-- Tampil jika role Dokter (2) --}}
                            @if(session('user_role') == 2)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('dokter.rekam-medis.index') }}">
                                    <i class="fas fa-file-medical-alt"></i> Rekam Medis
                                </a>
                            </li>
                            @endif
                            
                            {{-- Tampil jika role Perawat (3) --}}
                            @if(session('user_role') == 3)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('perawat.rekam-medis.index') }}">
                                    <i class="fas fa-file-medical-alt"></i> Rekam Medis
                                </a>
                            </li>
                            @endif

                            {{-- Tampil jika role Pemilik (bukan 1, 2, 3, atau 4) --}}
                            @if(!in_array(session('user_role'), [1, 2, 3, 4]))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('pemilik.pet.index') }}">
                                    <i class="fas fa-paw"></i> Pet Saya
                                </a>
                            </li>
                            @endif
                            {{-- === AKHIR LINK BARU === --}}

                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v_pre>
                                    {{ Auth::user()->nama }} {{-- Sesuai DB 'rshp' --}}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            {{-- Ini adalah tempat konten (seperti dashboard) akan dimuat --}}
            @yield('content')
        </main>
    </div>
</body>
</html>