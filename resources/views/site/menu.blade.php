<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSHP - Rumah Sakit Hewan Pendidikan Universitas Airlangga</title>

    <style>
        
    </style>

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    <header>
        {{-- Path untuk gambar juga harus menunjuk ke public/image --}}
        <img src="{{ asset('image/logorshp.png') }}" alt="Logo Unair" class="logo">
        <h1>RSHP - Rumah Sakit Hewan Pendidikan Universitas Airlangga</h1>
    </header>
    
    <nav>
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('struktur') }}">Struktur Organisasi</a></li>
            <li><a href="{{ route('layanan') }}">Layanan Publik</a></li>
            <li><a href="{{ route('visimisi') }}">Visi Misi dan Tujuan</a></li>
            <li><a href="{{ route('login') }}">Login</a></li>
        </ul>
    </nav>
    
    <main class="struktur">
        @yield('content')
    </main>
    
    <footer>
        <p>&copy; 2025 RSHP - Rumah Sakit Hewan Pendidikan Universitas Airlangga.</p>
    </footer>

</body>
</html>