<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RSHP - Rumah Sakit Hewan Pendidikan Universitas Airlangga</title>

    {{-- SEMUA CSS ANDA DITEMPATKAN LANGSUNG DI SINI --}}
    <style>
        :root {
            --primary-blue: #1e40af;
            --secondary-blue: #3b82f6;
            --light-blue: #dbeafe;
            --dark-blue: #1e3a8a;
            --black: #000000;
            --dark-gray: #1f2937;
            --light-gray: #f8fafc;
            --white: #ffffff;
            --text-dark: #374151;
            --text-light: #6b7280;
            --border-light: #e5e7eb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--white);
            overflow-x: hidden;
        }

        /* HEADER */
        header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            color: var(--white);
            text-align: center;
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
            animation: slideDown 0.8s ease-out;
        }

        header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .logo {
            height: 80px;
            margin-bottom: 1.5rem;
            animation: fadeInScale 1s ease-out 0.3s both;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        header h1 {
            font-size: 2rem;
            font-weight: 300;
            letter-spacing: 1px;
            animation: fadeInUp 1s ease-out 0.5s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* NAVIGATION */
        nav {
            background-color: var(--white);
            box-shadow: 0 2px 20px rgba(30, 64, 175, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: slideDown 0.8s ease-out 0.2s both;
        }

        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0;
        }

        nav ul li {
            position: relative;
        }

        nav ul li a {
            color: var(--text-dark);
            padding: 1.5rem 2rem;
            text-decoration: none;
            font-weight: 400;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            display: block;
        }

        nav ul li a::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--secondary-blue);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%);
        }

        nav ul li a:hover {
            color: var(--primary-blue);
            transform: translateY(-2px);
        }

        nav ul li a:hover::before {
            width: 100%;
        }

        /* Remove any arrow content or pseudo elements */
        nav ul li::before,
        nav ul li::after,
        nav ul li a::after {
            display: none !important;
            content: none !important;
        }

        /* MAIN CONTAINER */
        .struktur {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            text-align: justify;
        }

        /* SECTIONS */
        section {
            background: var(--white);
            margin: 4rem 0;
            padding: 3rem 0;
            animation: fadeInUp 0.8s ease-out;
        }

        section:first-child {
            margin-top: 2rem;
        }

        section h2 {
            color: var(--primary-blue);
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        section h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            width: 60px;
            height: 2px;
            background: var(--secondary-blue);
            transform: translateX(-50%);
        }

        section p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-light);
            margin-bottom: 1.5rem;
            text-align: center;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        /* CARDS GRID */
        .struktur-berita {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .struktur-card {
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 30px rgba(30, 64, 175, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border-light);
            animation: fadeInUp 0.8s ease-out;
            animation-fill-mode: both;
        }

        .struktur-card:nth-child(1) { animation-delay: 0.1s; }
        .struktur-card:nth-child(2) { animation-delay: 0.2s; }
        .struktur-card:nth-child(3) { animation-delay: 0.3s; }

        .struktur-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(30, 64, 175, 0.15);
        }

        .struktur-foto {
            width: 100%;
            height: 220px;
            object-fit: contain;
            margin: 0 auto;
            display: block;
            padding: 10px;
            background: var(--light-gray);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .struktur-card:hover .struktur-foto {
            transform: scale(1.05);
        }

        .struktur-info {
            padding: 1.5rem;
            text-align: center;
        }

        .struktur-info h3 {
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
            font-weight: 500;
        }

        .struktur-info p {
            color: var(--text-light);
            font-size: 0.95rem;
            margin: 0;
            animation: none;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 2rem 0;
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 30px rgba(30, 64, 175, 0.08);
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }

        table th, table td {
            padding: 1.5rem;
            text-align: left;
            border-bottom: 1px solid var(--border-light);
        }

        table th {
            background: var(--light-blue);
            color: var(--primary-blue);
            font-weight: 500;
            font-size: 1.1rem;
        }

        table td {
            color: var(--text-light);
            line-height: 1.6;
        }

        /* LISTS */
        section ul {
            list-style: none;
            padding-left: 0;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            text-align: left; 
        }

        section ul li {
            padding: 0.8rem 0;
            color: var(--text-light);
            position: relative;
            padding-left: 1.5rem;
            animation: fadeInLeft 0.8s ease-out;
            animation-fill-mode: both;
        }

        section ul li:nth-child(1) { animation-delay: 0.1s; }
        section ul li:nth-child(2) { animation-delay: 0.2s; }
        section ul li:nth-child(3) { animation-delay: 0.3s; }
        section ul li:nth-child(4) { animation-delay: 0.4s; }
        section ul li:nth-child(5) { animation-delay: 0.5s; }
        section ul li:nth-child(6) { animation-delay: 0.6s; }
        section td ul li {
            padding: 0.4rem 0 0.4rem 1.5rem; 
            animation-delay: 0.7s; 
        }
        section td ul {
            margin-left: 0;
        }


        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        section ul li::before {
            content: '→';
            color: var(--secondary-blue);
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        /* SERVICE SECTIONS (Spesifik untuk #layanan) */
        #layanan p b {
            color: var(--primary-blue);
            font-size: 1.3rem;
            display: block;
            margin: 2rem 0 1rem 0;
            text-align: left;
        }

        #layanan p {
            text-align: left;
            max-width: none;
            margin-left: 0;
            margin-right: 0;
        }
        
        #layanan ul {
            text-align: left;
            max-width: none;
            margin-left: 0;
            margin-right: 0;
        }


        /* FOOTER */
        footer {
            background: var(--dark-gray);
            color: var(--white);
            text-align: center;
            padding: 3rem 2rem;
            margin-top: 4rem;
            animation: fadeIn 1s ease-out 0.8s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        footer p {
            margin: 0;
            font-size: 0.95rem;
            color: #d1d5db;
            animation: none;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
            }
            
            nav ul li a {
                padding: 1rem;
                text-align: center; 
                border-bottom: 1px solid var(--border-light);
            }
            
            header h1 {
                font-size: 1.5rem;
            }
            
            section h2 {
                font-size: 2rem;
            }
            
            .struktur {
                padding: 0 1rem;
            }
            
            .struktur-berita {
                grid-template-columns: 1fr;
            }

            table, table th, table td {
                display: block;
                width: 100%;
            }
            table th, table td {
                text-align: left;
                padding: 1rem;
            }
            table th {
                background-color: var(--primary-blue); 
                color: var(--white);
            }
            table tr {
                margin-bottom: 1rem;
                display: block;
                border: 1px solid var(--border-light);
                border-radius: 8px;
                overflow: hidden;
            }
            table td {
                border-bottom: 1px solid var(--border-light);
            }
            table tr:last-child td:last-child {
                border-bottom: none; 
            }
            table td ul {
                padding-left: 0;
            }
        }

        /* SMOOTH SCROLLING */
        html {
            scroll-behavior: smooth;
        }

        /* OVERRIDE ANY EXTERNAL STYLES THAT MIGHT ADD ARROWS */
        nav ul li {
            list-style: none !important;
        }

        nav ul li:before {
            display: none !important;
        }

        nav a:before,
        nav a:after {
            display: none !important;
        }
    </style>
    
</head>
<body>
    <header>
        {{-- DIUBAH: 'image/' menjadi 'images/' --}}
        <img src="{{ asset('images/logorshp.png') }}" alt="Logo Unair" class="logo">
        <h1>RSHP - Rumah Sakit Hewan Pendidikan Universitas Airlangga</h1>
    </header>
    
    <nav>
        <ul>
            {{-- 
              =========================================================
              == PERBAIKAN: Mengganti route('home') menjadi route('site.home') ==
              =========================================================
            --}}
            <li><a href="{{ route('site.home') }}">Home</a></li>
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