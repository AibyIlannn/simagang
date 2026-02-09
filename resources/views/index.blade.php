<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Primary Meta Tags -->
    <title>SIMAGANG - Sistem Informasi Magang DPUPR Provinsi Banten | Platform PKL Resmi</title>
    <meta name="title" content="SIMAGANG - Sistem Informasi Magang DPUPR Provinsi Banten | Platform PKL Resmi">
    <meta name="description" content="Platform resmi penyedia ruang PKL dan magang di DPUPR Provinsi Banten. Program magang berkualitas untuk siswa SMK/SMA dengan pembimbing profesional dan sertifikat resmi.">
    <meta name="keywords" content="magang banten, PKL banten, praktek kerja lapangan, DPUPR Banten, magang SMK, magang SMA, sistem informasi magang, pendaftaran magang online, program magang pemerintah, dinas PUPR Banten, magang serang, lowongan magang banten">
    <meta name="author" content="DPUPR Provinsi Banten">
    <meta name="robots" content="index, follow">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url('/') }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="SIMAGANG - Sistem Informasi Magang DPUPR Provinsi Banten">
    <meta property="og:description" content="Platform resmi penyedia ruang PKL dan magang untuk sekolah di Provinsi Banten. Daftar sekarang dan wujudkan pengalaman magang berkualitas!">
    <meta property="og:image" content="{{ asset('image/ArtiLambang.png') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('image/ArtiLambang.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('image/ArtiLambang.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    <!-- Styles -->
    <style>
        :root {
            --primary-blue: #1e40af;
            --primary-blue-dark: #1e3a8a;
            --accent-gold: #f59e0b;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --bg-light: #f9fafb;
            --bg-dark: #111827;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        /* ============================================
           HEADER & NAVIGATION
           ============================================ */
        
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 900 !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 1.5rem 0;
        }
        
        header.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-md);
            padding: 1rem 0;
            z-index: 900 !important;
        }
        
        header.hidden {
            transform: translateY(-100%);
        }
        
        nav {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-section {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .logo-section h3 {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.02em;
        }
        
        header.scrolled .logo-section h3 {
            color: var(--primary-blue);
        }
        
        .logo-section small {
            font-size: 0.75rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.9);
            letter-spacing: 0.05em;
        }
        
        header.scrolled .logo-section small {
            color: var(--text-gray);
        }
        
        .nav-desktop {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .hamburger-btn {
            display: none;
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            transition: all 0.3s ease;
        }
        
        header.scrolled .hamburger-btn {
            color: var(--primary-blue);
        }
        
        /* ============================================
           MOBILE MENU
           ============================================ */
        
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 280px;
            height: 100vh;
            background: var(--white);
            box-shadow: -4px 0 20px rgba(0, 0, 0, 0.1);
            transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1001 !important;
            overflow-y: auto;
        }
        
        .mobile-menu.active {
            right: 0 !important;
        }
        
        .mobile-menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .mobile-menu-header h4 {
            font-size: 1.25rem;
            color: var(--primary-blue);
            font-weight: 700;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-gray);
            cursor: pointer;
            transition: color 0.3s ease;
        }
        
        .close-btn:hover {
            color: var(--primary-blue);
        }
        
        .mobile-menu-content {
            padding: 1.5rem;
        }
        
        .mobile-menu-item {
            margin-bottom: 1rem;
        }
        
        .mobile-menu-link {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .mobile-menu-link:hover {
            background: var(--bg-light);
            color: var(--primary-blue);
        }
        
        .mobile-menu-actions {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        /* ============================================
           OVERLAY
           ============================================ */
        
        .menu-overlay {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            background: rgba(0, 0, 0, 0.65) !important;
            backdrop-filter: blur(5px) !important;
            -webkit-backdrop-filter: blur(5px) !important;
            z-index: 1000 !important;
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transition: opacity 0.3s ease, visibility 0.3s ease !important;
        }
        
        .menu-overlay.active {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            cursor: pointer !important;
        }
        
        /* ============================================
           BUTTONS
           ============================================ */
        
        .btn {
            padding: 0.75rem 1.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-outline {
            background: transparent;
            color: var(--white);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .btn-outline-mobile {
            background: transparent;
            color: var(--primary-blue);
            border: 2px solid var(--primary-blue);
        }
        
        .btn-outline-mobile:hover {
            background: var(--primary-blue);
            color: var(--white);
        }
        
        header.scrolled .btn-outline {
            color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        
        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        header.scrolled .btn-outline:hover {
            background: var(--primary-blue);
            color: var(--white);
        }
        
        .btn-primary {
            background: var(--accent-gold);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background: #d97706;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        /* ============================================
           HERO SECTION
           ============================================ */
        
        .hero {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.5)), url('{{ asset('image/foto1.jpg') }}') center/cover no-repeat;
            display: flex;
            align-items: center;
            padding-top: 5rem;
            z-index: 1;
        }
        
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 1.5rem;
            width: 100%;
        }
        
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }
        
        .hero-left {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        
        .hero-content {
            color: var(--white);
        }
        
        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }
        
        .hero-content .btn {
            font-size: 1.1rem;
            padding: 1rem 2.5rem;
        }
        
        /* ============================================
           INFO CARDS
           ============================================ */
        
        .info-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }
        
        .info-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            height: 200px;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-xl);
        }
        
        .info-card-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--white);
            margin-bottom: 0.5rem;
        }
        
        .info-card-subtitle {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0.75rem;
        }
        
        .info-card-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent-gold);
            margin-bottom: 1rem;
        }
        
        /* ============================================
           REGISTRATION CARD
           ============================================ */
        
        .registration-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 0.875rem;
            padding: 1.75rem;
            box-shadow: var(--shadow-xl);
            border: 1px solid #e5e7eb;
            height: auto;
        }
        
        .registration-card h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.375rem;
        }
        
        .registration-card .subtitle {
            font-size: 0.95rem;
            color: var(--text-gray);
            margin-bottom: 1.25rem;
        }
        
        .divider {
            margin: 1.25rem 0;
            border: none;
            height: 1px;
            background-color: #e5e7eb;
        }
        
        .list {
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
            margin-bottom: 1.625rem;
        }
        
        .list-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.95rem;
            color: #374151;
            line-height: 1.5;
        }
        
        .list-item i {
            color: #22c55e;
            margin-top: 0.1875rem;
            flex-shrink: 0;
        }
        
        .registration-card .btn-primary {
            width: 100%;
            padding: 0.875rem;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 0.625rem;
            transition: background-color 0.2s ease;
        }
        
        .registration-card .btn-primary:hover {
            background: #d97706;
        }
        
        /* ============================================
           FOOTER
           ============================================ */
        
        footer {
            background: var(--bg-dark);
            color: rgba(255, 255, 255, 0.8);
            padding: 3.5rem 0 1.5rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 3rem;
            margin-bottom: 2.5rem;
        }
        
        .footer-brand h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 0.5rem;
        }
        
        .footer-brand p {
            font-size: 0.9rem;
            line-height: 1.7;
            margin-bottom: 1.25rem;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .social-links {
            display: flex;
            gap: 0.75rem;
        }
        
        .social-link {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .social-link:hover {
            background: var(--primary-blue);
            color: var(--white);
            transform: translateY(-2px);
        }
        
        .footer-section h4 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--white);
            margin-bottom: 1.25rem;
        }
        
        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            align-items: flex-start;
            padding: 0;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            text-align: left;
            font-size: 0.9rem;
            transition: color 0.3s ease;
            padding: 0;
        }
        
        .footer-links a:hover {
            color: var(--white);
            padding-left: 0.5rem;
        }
        
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }
        
        .contact-item i {
            color: var(--accent-gold);
            margin-top: 0.25rem;
            font-size: 0.95rem;
        }
        
        .contact-item div {
            flex: 1;
        }
        
        .contact-item a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .contact-item a:hover {
            color: var(--white);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            text-align: center;
        }
        
        .footer-bottom p {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.6);
        }
        
        /* ============================================
           ANIMATIONS
           ============================================ */
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        /* ============================================
           RESPONSIVE STYLES
           ============================================ */
        
        @media screen and (max-width: 1024px) {
            .info-card {
                display: none;
            }
            
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            h1 {
                margin-top: 5rem;
            }
            
            nav {
                padding: 0 2rem;
            }
            
            .container {
                padding: 0 2rem;
            }
            
            .hero-content h1 {
                font-size: 2.75rem;
            }
            
            .info-cards {
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }
            
            .registration-card {
                width: 100%;
                height: auto;
            }
            
            .footer-content {
                grid-template-columns: 2fr 1fr 1fr 1.5fr;
                gap: 2rem;
            }
        }
        
        @media screen and (max-width: 768px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .hero {
                padding-top: 4rem;
                min-height: auto;
                padding-bottom: 2rem;
            }
            
            .hero-content h1 {
                font-size: 2.25rem;
            }
            
            .info-cards {
                display: block;
            }
            
            .info-card {
                margin-bottom: 1rem;
            }
            
            .info-card:last-child {
                margin-bottom: 0;
            }
            
            .registration-card {
                margin-top: 1rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }
            
            .footer-brand {
                grid-column: 1 / -1;
            }
        }
        
        @media screen and (max-width: 640px) {
            .nav-desktop {
                display: none;
            }
            
            .hamburger-btn {
                display: block;
            }
            
            nav {
                padding: 0 1.25rem;
            }
            
            .container {
                padding: 0 1.25rem;
            }
            
            .logo-section h3 {
                font-size: 1.5rem;
            }
            
            .logo-section small {
                font-size: 0.7rem;
            }
            
            .hero {
                padding-top: 5rem;
                padding-bottom: 2rem;
            }
            
            .hero-content h1 {
                font-size: 1.875rem;
                margin-bottom: 1rem;
            }
            
            .hero-content .btn {
                font-size: 1rem;
                padding: 0.875rem 1.75rem;
                width: 100%;
            }
            
            .registration-card {
                padding: 1.5rem;
            }
            
            .registration-card h2 {
                font-size: 1.25rem;
            }
            
            .list-item {
                font-size: 0.9rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .footer-brand {
                grid-column: 1;
            }
        }
        
        @media screen and (max-width: 360px) {
            nav {
                padding: 0 1rem;
            }
            
            .container {
                padding: 0 1rem;
            }
            
            .logo-section h3 {
                font-size: 1.35rem;
            }
            
            .logo-section small {
                font-size: 0.65rem;
            }
            
            .hero-content h1 {
                font-size: 1.625rem;
            }
            
            .info-card {
                padding: 1.25rem;
            }
            
            .registration-card {
                padding: 1.25rem;
            }
        }
        
        @media screen and (min-width: 1440px) {
            nav {
                padding: 0 3rem;
            }
            
            .container {
                padding: 0 3rem;
            }
        }
        
        @media screen and (min-width: 1824px) {
            .container {
                max-width: 1600px;
            }
            
            .hero-content h1 {
                font-size: 4rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header id="mainHeader">
        <nav role="navigation" aria-label="Main Navigation">
            <div class="logo-section">
                <h3>SIMAGANG</h3>
                <small>Sistem Informasi Magang DPUPR Banten</small>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="nav-desktop">
                @auth('admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline" aria-label="Dashboard Admin">
                        <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>Dashboard
                    </a>
                @elseif(auth('web')->check())
                    @if(auth('web')->user()->role === 'INSTITUSI')
                        <a href="{{ route('institusi.dashboard') }}" class="btn btn-outline" aria-label="Dashboard Institusi">
                            <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>Dashboard
                        </a>
                    @elseif(auth('web')->user()->role === 'PESERTA')
                        <a href="{{ route('peserta.dashboard') }}" class="btn btn-outline" aria-label="Dashboard Peserta">
                            <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn btn-outline" aria-label="Daftar">Daftar</a>
                    <a href="{{ route('login') }}" class="btn btn-primary" aria-label="Masuk ke Sistem">Masuk</a>
                @endauth
            </div>
            
            <!-- Mobile Hamburger Button -->
            <button class="hamburger-btn" 
                    id="hamburgerBtn"
                    aria-label="Buka Menu" 
                    aria-expanded="false">
                <i class="fas fa-bars"></i>
            </button>
        </nav>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <div class="mobile-menu-header">
                <h4>Menu</h4>
                <button class="close-btn" 
                        id="closeMenuBtn"
                        aria-label="Tutup Menu">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="mobile-menu-content">
                <div class="mobile-menu-item">
                    <a href="{{ route('home') }}" class="mobile-menu-link">Beranda</a>
                </div>
                
                <div class="mobile-menu-item">
                    <a href="#footer" class="mobile-menu-link">Kontak</a>
                </div>
                
                <div class="mobile-menu-actions">
                    @auth('admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>Dashboard
                        </a>
                    @elseif(auth('web')->check())
                        @if(auth('web')->user()->role === 'INSTITUSI')
                            <a href="{{ route('institusi.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>Dashboard
                            </a>
                        @elseif(auth('web')->user()->role === 'PESERTA')
                            <a href="{{ route('peserta.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-tachometer-alt" style="margin-right: 0.5rem;"></i>Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="btn btn-outline-mobile">Daftar</a>
                        <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Overlay -->
        <div class="menu-overlay" id="menuOverlay" aria-hidden="true"></div>
    </header>

    <!-- Main Content -->
    <main>
        <section class="hero" aria-labelledby="hero-heading">
            <div class="container">
                <div class="hero-grid">
                    <!-- Hero Left Content -->
                    <div class="hero-left">
                        <article class="hero-content fade-in-up">
                            <h1 id="hero-heading">Wujudkan Pengalaman Magang Berkualitas untuk Generasi Banten</h1>
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                Ajukan Kerja Sama <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
                            </a>
                        </article>

                        <!-- Info Cards -->
                        <div class="info-cards fade-in-up">
                            <article class="info-card">
                                <h3 class="info-card-title">Bidang Teknik</h3>
                                <p class="info-card-subtitle">Pengalaman langsung di proyek infrastruktur</p>
                                <div class="info-card-price">100+ Kuota</div>
                            </article>

                            <article class="info-card">
                                <h3 class="info-card-title">Administrasi</h3>
                                <p class="info-card-subtitle">Kelola dokumen dan sistem pemerintahan</p>
                                <div class="info-card-price">75+ Kuota</div>
                            </article>

                            <article class="info-card">
                                <h3 class="info-card-title">IT &amp; Digital</h3>
                                <p class="info-card-subtitle">Teknologi informasi modern</p>
                                <div class="info-card-price">50+ Kuota</div>
                            </article>
                        </div>
                    </div>

                    <!-- Registration Card -->
                    <aside class="registration-card fade-in-up" aria-labelledby="registration-heading">
                        <h2 id="registration-heading">Program Magang DPUPR Provinsi Banten</h2>
                        <p class="subtitle">Wujudkan pengalaman magang berkualitas dan terstruktur untuk siswa-siswi terbaik</p>
                        
                        <hr class="divider">
                        
                        <div class="list">
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Program magang telah diverifikasi dan diawasi langsung oleh Pemerintah Provinsi Banten</span>
                            </div>
                            
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Didukung oleh lembaga pemerintahan resmi dengan standar profesional tinggi</span>
                            </div>
                            
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Proses seleksi peserta magang yang transparan dan terstruktur</span>
                            </div>
                            
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Penempatan peserta disesuaikan dengan latar belakang pendidikan</span>
                            </div>
                           
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Monitoring dan evaluasi kegiatan magang dilakukan secara berkala</span>
                            </div>
                            
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Program dirancang sesuai kebutuhan dunia kerja modern</span>
                            </div>
                            
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Data dijamin keamanannya dengan sistem enkripsi standar pemerintahan</span>
                            </div>
                            
                            <div class="list-item">
                                <i class="fa-solid fa-circle-check"></i>
                                <span>Kurikulum disesuaikan dengan standar kompetensi tingkat nasional</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar Sekarang</a>
                    </aside>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="footer">
        <div class="container">
            <div class="footer-content">
                <!-- Footer Brand -->
                <div class="footer-brand">
                    <h3>SIMAGANG</h3>
                    <p>Platform resmi penyedia ruang magang dan PKL untuk meningkatkan kompetensi siswa</p>
                    <div class="social-links">
                        <a href="https://instagram.com/dpupr.banten" 
                           class="social-link" 
                           aria-label="Instagram DPUPR Banten" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://facebook.com/dpupr.banten" 
                           class="social-link" 
                           aria-label="Facebook DPUPR Banten" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://youtube.com/@dpuprbanten" 
                           class="social-link" 
                           aria-label="YouTube DPUPR Banten" 
                           target="_blank" 
                           rel="noopener noreferrer">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Footer Menu -->
                <div class="footer-section">
                    <h4>Menu</h4>
                    <nav class="footer-links" aria-label="Footer Menu">
                        <a href="{{ route('home') }}">Beranda</a>
                        <a href="#footer">Kontak</a>
                    </nav>
                </div>

                <!-- Footer Layanan -->
                <div class="footer-section">
                    <h4>Layanan</h4>
                    <nav class="footer-links" aria-label="Footer Layanan">
                        <a href="{{ route('register') }}">Pendaftaran Peserta Magang</a>
                    </nav>
                </div>

                <!-- Footer Contact -->
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <address class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>Jl. Syekh Nawawi Al-Bantani, Serang, Banten 42111</div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <a href="mailto:kontak@pupr.bantenprov.go.id">kontak@pupr.bantenprov.go.id</a>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <a href="tel:+622541234456">(0254) 123 456</a>
                            </div>
                        </div>
                    </address>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} DPUPR Provinsi Banten. Platform Sistem Informasi Magang.</p>
            </div>
        </div>
    </footer>

    <!-- Vanilla JavaScript -->
    <script>
        (function() {
            'use strict';
            
            const header = document.getElementById('mainHeader');
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const closeMenuBtn = document.getElementById('closeMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuOverlay = document.getElementById('menuOverlay');
            const mobileMenuLinks = document.querySelectorAll('.mobile-menu-link, .mobile-menu-actions a');
            
            let lastScroll = 0;
            let isMenuOpen = false;
            
            function handleScroll() {
                const currentScroll = window.pageYOffset;
                
                if (currentScroll > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                
                if (currentScroll > lastScroll && currentScroll > 200) {
                    header.classList.add('hidden');
                } else {
                    header.classList.remove('hidden');
                }
                
                lastScroll = currentScroll;
            }
            
            function openMobileMenu() {
                isMenuOpen = true;
                mobileMenu.classList.add('active');
                menuOverlay.classList.add('active');
                hamburgerBtn.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }
            
            function closeMobileMenu() {
                isMenuOpen = false;
                mobileMenu.classList.remove('active');
                menuOverlay.classList.remove('active');
                hamburgerBtn.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }
            
            window.addEventListener('scroll', handleScroll, { passive: true });
            hamburgerBtn.addEventListener('click', openMobileMenu);
            closeMenuBtn.addEventListener('click', closeMobileMenu);
            menuOverlay.addEventListener('click', closeMobileMenu);
            
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', closeMobileMenu);
            });
            
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isMenuOpen) {
                    closeMobileMenu();
                }
            });
            
            mobileMenu.addEventListener('touchmove', function(e) {
                e.stopPropagation();
            }, { passive: false });
            
        })();
    </script>
</body>
</html>