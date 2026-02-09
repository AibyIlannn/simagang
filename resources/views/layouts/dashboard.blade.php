<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SIMAGANG</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --sidebar-width: 260px;
            --header-height: 70px;
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --text-light: #9ca3af;
            --bg-main: #f9fafb;
            --bg-white: #ffffff;
            --border-color: #e5e7eb;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-main);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ============================================
           SIDEBAR
           ============================================ */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: white;
            text-decoration: none;
        }

        .sidebar-brand i {
            width: 36px;
            height: 36px;
            background: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
        }

        .sidebar-brand-text h3 {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .sidebar-brand-text span {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem 0;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-section-title {
            padding: 0 1.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 0.5rem;
        }

        .nav-item {
            margin: 0.25rem 0.75rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 0.875rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .nav-link:hover {
            background: var(--sidebar-hover);
            color: white;
        }

        .nav-link.active {
            background: var(--primary-color);
            color: white;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* ============================================
           HEADER
           ============================================ */

        .header {
            position: fixed;
            left: var(--sidebar-width);
            right: 0;
            top: 0;
            height: var(--header-height);
            background: var(--bg-white);
            border-bottom: 1px solid var(--border-color);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
        }

        .header-left h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .datetime-display {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            background: var(--bg-main);
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .datetime-display i {
            color: var(--primary-color);
            font-size: 0.875rem;
        }

        .datetime-text {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
        }

        .datetime-date {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .datetime-time {
            font-size: 0.7rem;
            color: var(--text-gray);
        }

        .notification-icon {
            position: relative;
            width: 40px;
            height: 40px;
            background: var(--bg-main);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid var(--border-color);
        }

        .notification-icon:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .notification-icon i {
            font-size: 1.125rem;
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 18px;
            height: 18px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            font-size: 0.625rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--bg-white);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            background: var(--bg-main);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid var(--border-color);
        }

        .user-info:hover {
            border-color: var(--primary-color);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 0.125rem;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .user-role {
            font-size: 0.7rem;
            color: var(--text-gray);
        }

        /* ============================================
           MAIN CONTENT
           ============================================ */

        .main-wrapper {
            margin-left: var(--sidebar-width);
            padding-top: var(--header-height);
            min-height: 100vh;
        }

        .main-content {
            padding: 2rem;
        }

        /* ============================================
           MOBILE RESPONSIVE
           ============================================ */

        .mobile-toggle {
            display: none;
            width: 40px;
            height: 40px;
            background: var(--bg-main);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .mobile-toggle:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-overlay.active {
                display: block;
            }

            .header {
                left: 0;
            }

            .main-wrapper {
                margin-left: 0;
            }

            .mobile-toggle {
                display: flex;
            }

            .datetime-text {
                display: none;
            }

            .user-details {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .header {
                padding: 0 1rem;
            }

            .header-left h1 {
                font-size: 1.125rem;
            }

            .header-right {
                gap: 0.75rem;
            }

            .main-content {
                padding: 1.25rem;
            }

            .datetime-display {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route(auth('admin')->check() ? 'admin.dashboard' : (auth('web')->user()->role === 'INSTITUSI' ? 'institusi.dashboard' : 'peserta.dashboard')) }}" class="sidebar-brand">
                <i class="fas fa-graduation-cap"></i>
                <div class="sidebar-brand-text">
                    <h3>SIMAGANG</h3>
                    <span>DPUPR Banten</span>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            @if(auth('admin')->check())
                {{-- Admin Sidebar --}}
                <div class="nav-section">
                    <div class="nav-section-title">Dashboard</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard Utama</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Manajemen Data</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.institusi.index') }}" class="nav-link {{ request()->routeIs('admin.institusi.*') ? 'active' : '' }}">
                            <i class="fas fa-school"></i>
                            <span>Data Institusi</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.peserta.index') }}" class="nav-link {{ request()->routeIs('admin.peserta.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Data Peserta</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Data Laporan</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Validasi</div>
                    <div class="nav-item">
                        <a href="{{ route('admin.validasi.institusi') }}" class="nav-link {{ request()->routeIs('admin.validasi.institusi') ? 'active' : '' }}">
                            <i class="fas fa-check-circle"></i>
                            <span>Validasi Institusi</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Akun</div>
                    <div class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; cursor: pointer;">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>

            @elseif(auth('web')->check() && auth('web')->user()->role === 'INSTITUSI')
                {{-- Institusi Sidebar --}}
                <div class="nav-section">
                    <div class="nav-section-title">Dashboard</div>
                    <div class="nav-item">
                        <a href="{{ route('institusi.dashboard') }}" class="nav-link {{ request()->routeIs('institusi.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard Institusi</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Manajemen</div>
                    <div class="nav-item">
                        <a href="{{ route('institusi.profil') }}" class="nav-link {{ request()->routeIs('institusi.profil') ? 'active' : '' }}">
                            <i class="fas fa-user-circle"></i>
                            <span>Profil Institusi</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('institusi.peserta.index') }}" class="nav-link {{ request()->routeIs('institusi.peserta.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Data Peserta</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('institusi.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('institusi.pendaftaran.*') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Pendaftaran</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Laporan</div>
                    <div class="nav-item">
                        <a href="{{ route('institusi.laporan.index') }}" class="nav-link {{ request()->routeIs('institusi.laporan.*') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Laporan Peserta</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Akun</div>
                    <div class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; cursor: pointer;">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>

            @elseif(auth('web')->check() && auth('web')->user()->role === 'PESERTA')
                {{-- Peserta Sidebar --}}
                <div class="nav-section">
                    <div class="nav-section-title">Dashboard</div>
                    <div class="nav-item">
                        <a href="{{ route('peserta.dashboard') }}" class="nav-link {{ request()->routeIs('peserta.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i>
                            <span>Dashboard Peserta</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Profil</div>
                    <div class="nav-item">
                        <a href="{{ route('peserta.profil') }}" class="nav-link {{ request()->routeIs('peserta.profil') ? 'active' : '' }}">
                            <i class="fas fa-user-circle"></i>
                            <span>Profil Saya</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('peserta.status') }}" class="nav-link {{ request()->routeIs('peserta.status') ? 'active' : '' }}">
                            <i class="fas fa-info-circle"></i>
                            <span>Status Pendaftaran</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Laporan</div>
                    <div class="nav-item">
                        <a href="{{ route('peserta.laporan.index') }}" class="nav-link {{ request()->routeIs('peserta.laporan.index') ? 'active' : '' }}">
                            <i class="fas fa-file-alt"></i>
                            <span>Daftar Laporan</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('peserta.laporan.create') }}" class="nav-link {{ request()->routeIs('peserta.laporan.create') ? 'active' : '' }}">
                            <i class="fas fa-plus-circle"></i>
                            <span>Buat Laporan</span>
                        </a>
                    </div>
                </div>

                <div class="nav-section">
                    <div class="nav-section-title">Akun</div>
                    <div class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link" style="width: 100%; background: none; border: none; cursor: pointer;">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </nav>
    </aside>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="mobile-toggle" id="mobileToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1>@yield('page-title', 'Dashboard')</h1>
        </div>

        <div class="header-right">
            <!-- Date Time Display -->
            <div class="datetime-display">
                <i class="fas fa-clock"></i>
                <div class="datetime-text">
                    <div class="datetime-date" id="currentDate">Loading...</div>
                    <div class="datetime-time" id="currentTime">Loading...</div>
                </div>
            </div>

            <!-- Notification Icon -->
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </div>

            <!-- User Info -->
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth('admin')->check() ? auth('admin')->user()->name : auth('web')->user()->name, 0, 2)) }}
                </div>
                <div class="user-details">
                    <div class="user-name">{{ auth('admin')->check() ? auth('admin')->user()->name : auth('web')->user()->name }}</div>
                    <div class="user-role">{{ auth('admin')->check() ? auth('admin')->user()->role : auth('web')->user()->role }}</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-wrapper">
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script>
        // Mobile Toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        mobileToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });

        // Date Time Update
        function updateDateTime() {
            const now = new Date();
            
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                          'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            
            const dateString = `${dayName}, ${date} ${month} ${year}`;
            const timeString = `${hours}:${minutes} WIB`;
            
            document.getElementById('currentDate').textContent = dateString;
            document.getElementById('currentTime').textContent = timeString;
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

    @stack('scripts')
</body>
</html>