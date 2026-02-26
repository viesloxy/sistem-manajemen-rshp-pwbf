<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
      <img
        src="{{ asset('assets/img/AdminLTELogo.png') }}"
        alt="AdminLTE Logo"
        class="brand-image opacity-75 shadow"
      />
      <span class="brand-text fw-light">RSHP Admin</span>
    </a>
  </div>
  
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
        
        <!-- =============================================== -->
        <!-- MENU KHUSUS ADMINISTRATOR                       -->
        <!-- =============================================== -->
        @if(session('user_role_name') == 'Administrator')
            
            <!-- DASHBOARD -->
            <li class="nav-item mb-2">
              <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon bi bi-speedometer2"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <!-- MASTER DATA DROPDOWN -->
            <li class="nav-item {{ Request::is('admin/*') && !Request::routeIs('admin.dashboard') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ Request::is('admin/*') && !Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon bi bi-database-fill-gear"></i>
                <p>
                  Data Master
                  <i class="nav-arrow bi bi-chevron-right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                
                <!-- KELOMPOK 1: PENGGUNA -->
                <li class="nav-item">
                  <a href="{{ route('admin.user.index') }}" class="nav-link {{ Request::routeIs('admin.user.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-people-fill"></i>
                    <p>Data User</p>
                  </a>
                </li>
                <li class="nav-item border-bottom border-secondary mb-2 pb-2">
                  <a href="{{ route('admin.role.index') }}" class="nav-link {{ Request::routeIs('admin.role.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-shield-lock-fill"></i>
                    <p>Manajemen Role</p>
                  </a>
                </li>

                <!-- KELOMPOK 2: HEWAN -->
                <li class="nav-item">
                  <a href="{{ route('admin.jenis-hewan.index') }}" class="nav-link {{ Request::routeIs('admin.jenis-hewan.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-github"></i> 
                    <p>Jenis Hewan</p>
                  </a>
                </li>
                <li class="nav-item border-bottom border-secondary mb-2 pb-2">
                  <a href="{{ route('admin.ras-hewan.index') }}" class="nav-link {{ Request::routeIs('admin.ras-hewan.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-diagram-3-fill"></i>
                    <p>Ras Hewan</p>
                  </a>
                </li>

                <!-- KELOMPOK 3: KLIEN -->
                <li class="nav-item">
                  <a href="{{ route('admin.pemilik.index') }}" class="nav-link {{ Request::routeIs('admin.pemilik.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-person-vcard-fill"></i>
                    <p>Data Pemilik</p>
                  </a>
                </li>
                <li class="nav-item border-bottom border-secondary mb-2 pb-2">
                  <a href="{{ route('admin.pet.index') }}" class="nav-link {{ Request::routeIs('admin.pet.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-heart-pulse-fill"></i>
                    <p>Data Pet</p>
                  </a>
                </li>

                <!-- KELOMPOK 4: MEDIS -->
                <li class="nav-item">
                  <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ Request::routeIs('admin.kategori.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-tag-fill"></i>
                    <p>Data Kategori</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('admin.kategori-klinis.index') }}" class="nav-link {{ Request::routeIs('admin.kategori-klinis.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-hospital-fill"></i>
                    <p>Kategori Klinis</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('admin.kode-tindakan-terapi.index') }}" class="nav-link {{ Request::routeIs('admin.kode-tindakan-terapi.*') ? 'active' : '' }}">
                    <i class="nav-icon bi bi-clipboard2-pulse-fill"></i>
                    <p>Kode Tindakan</p>
                  </a>
                </li>

              </ul>
            </li>
        @endif

        {{-- ===================== RESEPSIONIS ===================== --}}
        @if(session('user_role_name') == 'Resepsionis')
            <li class="nav-header mt-3">RESEPSIONIS</li>

            <li class="nav-item">
              <a href="{{ route('resepsionis.dashboard') }}" class="nav-link {{ Request::routeIs('resepsionis.dashboard') ? 'active' : '' }}">
                <i class="nav-icon bi bi-speedometer2"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('resepsionis.pemilik.index') }}" class="nav-link {{ Request::routeIs('resepsionis.pemilik.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-person-plus-fill"></i>
                <p>Registrasi Pemilik</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('resepsionis.pet.index') }}" class="nav-link {{ Request::routeIs('resepsionis.pet.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-paw"></i>
                <p>Registrasi Pet</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('resepsionis.temu-dokter.index') }}" class="nav-link {{ Request::routeIs('resepsionis.temu-dokter.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-list-ol"></i>
                <p>Temu Dokter & Antrian</p>
              </a>
            </li>
        @endif


        {{-- ===================== DOKTER ===================== --}}
        @if(session('user_role_name') == 'Dokter')
            <li class="nav-header mt-3">DOKTER</li>

            <li class="nav-item">
              <a href="{{ route('dokter.dashboard') }}" class="nav-link {{ Request::routeIs('dokter.dashboard') ? 'active' : '' }}">
                <i class="nav-icon bi bi-speedometer2"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('dokter.rekam-medis.index') }}" class="nav-link {{ Request::routeIs('dokter.rekam-medis.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-journal-medical"></i>
                <p>Rekam Medis</p>
              </a>
            </li>
        @endif


        {{-- ===================== PERAWAT ===================== --}}
        @if(session('user_role_name') == 'Perawat')
            <li class="nav-header mt-3">PERAWAT</li>

            <li class="nav-item">
              <a href="{{ route('perawat.dashboard') }}" class="nav-link {{ Request::routeIs('perawat.dashboard') ? 'active' : '' }}">
                <i class="nav-icon bi bi-speedometer2"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('perawat.rekam-medis.index') }}" class="nav-link {{ Request::routeIs('perawat.rekam-medis.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-journal-check"></i>
                <p>Rekam Medis</p>
              </a>
            </li>
        @endif


        {{-- ===================== PEMILIK ===================== --}}
        @if(session('user_role_name') == 'Pemilik')
            <li class="nav-header mt-3">PEMILIK</li>

            <li class="nav-item">
              <a href="{{ route('pemilik.dashboard') }}" class="nav-link {{ Request::routeIs('pemilik.dashboard') ? 'active' : '' }}">
                <i class="nav-icon bi bi-speedometer2"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('pemilik.pet.list') }}" class="nav-link {{ Request::routeIs('pemilik.pet.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-paw"></i>
                <p>Pet Saya</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('pemilik.temu-dokter.list') }}" class="nav-link {{ Request::routeIs('pemilik.temu-dokter.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-calendar-check"></i>
                <p>Temu Dokter</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('pemilik.rekammedis.list') }}" class="nav-link {{ Request::routeIs('pemilik.rekammedis.*') ? 'active' : '' }}">
                <i class="nav-icon bi bi-file-medical"></i>
                <p>Rekam Medis</p>
              </a>
            </li>
        @endif


        <!-- LOGOUT -->
        <li class="nav-header mt-3">ACCOUNT</li>
        <li class="nav-item">
            <a class="nav-link text-danger" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="nav-icon bi bi-box-arrow-right"></i>
                <p>Logout</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>

      </ul>
    </nav>
  </div>
</aside>
