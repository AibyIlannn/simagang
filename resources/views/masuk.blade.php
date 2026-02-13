<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIMAGANG - Sistem Informasi Magang DPUPR Provinsi Banten">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - SIMAGANG</title>

     <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('image/ArtiLambang.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('image/ArtiLambang.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-purple: #6366f1;
            --primary-purple-dark: #4f46e5;
            --accent-orange: #f97316;
            --accent-orange-dark: #ea580c;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --bg-overlay: rgba(15, 23, 42, 0.75);
            --shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.25);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-image: url('{{ asset('image/foto1.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--bg-overlay);
            backdrop-filter: blur(3px);
            z-index: 1;
        }

        .login-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 900px;
            animation: fadeInUp 0.6s ease-out;
        }

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

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            display: grid;
            grid-template-columns: 45% 55%;
            min-height: 600px;
        }

        .welcome-panel {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.95) 0%, rgba(79, 70, 229, 0.95) 100%),
                        url('{{ asset('image/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            position: relative;
        }

        .welcome-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .brand-section {
            position: relative;
            z-index: 2;
        }

        .brand-logo {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 16px;
            margin-bottom: 60px;
        }

        .brand-logo img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .brand-name {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }

        .brand-subtitle {
            font-size: 13px;
            font-weight: 500;
            opacity: 0.95;
            line-height: 1.3;
        }

        .welcome-content {
            position: relative;
            z-index: 2;
        }

        .welcome-title {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.1;
        }

        .welcome-subtitle {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.95;
            margin-bottom: 48px;
        }

        .signup-section {
            position: relative;
            z-index: 2;
        }

        .signup-text {
            font-size: 14px;
            margin-bottom: 16px;
            opacity: 0.9;
        }

        .btn-signup {
            display: inline-block;
            padding: 12px 32px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 50px;
            color: white;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-signup:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: white;
            transform: translateY(-2px);
        }

        .form-panel {
            padding: 48px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 32px;
        }

        .form-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            margin-bottom: 24px;
            color: #991b1b;
            font-size: 14px;
            animation: slideDown 0.3s ease-out;
        }

        .alert.success {
            background: #f0fdf4;
            border-color: #bbf7d0;
            color: #166534;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-icon {
            color: #dc2626;
            flex-shrink: 0;
        }

        .alert.success .alert-icon {
            color: #16a34a;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            font-size: 15px;
            font-family: inherit;
            color: var(--text-dark);
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-input::placeholder {
            color: transparent;
        }

        .form-input:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-input.error {
            border-color: #dc2626;
            background-color: #fef2f2;
        }

        .form-label {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            font-weight: 500;
            color: var(--text-light);
            background: white;
            padding: 0 6px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }

        .form-input:focus ~ .form-label,
        .form-input:not(:placeholder-shown) ~ .form-label {
            top: 0;
            left: 12px;
            font-size: 12px;
            font-weight: 600;
            color: var(--primary-purple);
            transform: translateY(-50%);
        }

        .form-input.error ~ .form-label {
            color: #dc2626;
        }

        .form-input:not(:focus):not(:placeholder-shown) ~ .form-label {
            color: var(--text-gray);
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-gray);
            cursor: pointer;
            padding: 8px;
            font-size: 16px;
            transition: color 0.2s;
            border-radius: 6px;
            z-index: 10;
        }

        .toggle-password:hover {
            color: var(--text-dark);
            background: #f1f5f9;
        }

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--primary-purple);
        }

        .remember-me label {
            font-size: 13px;
            color: var(--text-gray);
            cursor: pointer;
            font-weight: 500;
        }

        .forgot-password {
            font-size: 13px;
            color: var(--primary-purple);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: var(--primary-purple-dark);
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 14px 24px;
            font-size: 15px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--primary-purple-dark) 100%);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit.loading {
            color: transparent;
            pointer-events: none;
        }

        .btn-submit.loading::after {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            top: 50%;
            left: 50%;
            margin: -9px 0 0 -9px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .form-footer-copyright {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .form-footer-copyright p {
            font-size: 12px;
            color: var(--text-gray);
            margin: 0;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
            .login-card {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .welcome-panel {
                display: none;
            }

            .form-panel {
                padding: 36px 28px;
            }

            body {
                padding: 20px 16px;
            }
        }

        @media (max-width: 480px) {
            .form-panel {
                padding: 32px 24px;
            }

            .welcome-title {
                font-size: 32px;
            }

            .form-header h1 {
                font-size: 24px;
            }
        }

        *:focus-visible {
            outline: 2px solid var(--primary-purple);
            outline-offset: 2px;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body>
    <div class="login-wrapper" x-data="loginApp()" x-cloak>
        <div class="login-card">
            <!-- LEFT PANEL -->
            <div class="welcome-panel">
                <div class="brand-section">
                    <div class="brand-logo">
                        <img src="{{ asset('image/ArtiLambang.png') }}" alt="Logo Provinsi Banten">
                        <div class="brand-text">
                            <div class="brand-name">SIMAGANG</div>
                            <div class="brand-subtitle">Aplikasi Magang DPUPR Provinsi Banten</div>
                        </div>
                    </div>
                </div>

                <div class="welcome-content">
                    <h2 class="welcome-title">Halo!</h2>
                    <p class="welcome-subtitle">
                        Selamat Datang Kembali.<br>
                        Anda hanya selangkah lagi untuk masuk.
                    </p>
                </div>

                <div class="signup-section">
                    <p class="signup-text">Belum punya akun?</p>
                    <a href="{{ route('register') }}" class="btn-signup">
                        Daftar Sekarang
                    </a>
                </div>
            </div>

            <!-- RIGHT PANEL -->
            <div class="form-panel">
                <header class="form-header">
                    <h1>MASUK</h1>
                </header>

                <!-- Laravel Session Messages -->
                @if(session('success'))
                <div class="alert success">
                    <div class="alert-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="alert-content">
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="alert">
                    <div class="alert-icon">
                        <i class="fa-solid fa-circle-exclamation"></i>
                    </div>
                    <div class="alert-content">
                        <p>{{ $errors->first() }}</p>
                    </div>
                </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login.submit') }}" method="POST" @submit="isLoading = true">
                    @csrf

                    <!-- Email/Username -->
                    <div class="form-group">
                        <input 
                            type="text" 
                            id="email"
                            name="email"
                            class="form-input @error('email') error @enderror"
                            placeholder="Email atau Username"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            x-model="email"
                        >
                        <label for="email" class="form-label">Email atau Username</label>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <div class="password-wrapper">
                            <input 
                                :type="showPassword ? 'text' : 'password'"
                                id="password"
                                name="password"
                                class="form-input @error('password') error @enderror"
                                placeholder="Password"
                                required
                                autocomplete="current-password"
                                x-model="password"
                            >
                            <label for="password" class="form-label">Password</label>
                            <button 
                                type="button"
                                class="toggle-password"
                                @click="showPassword = !showPassword"
                                :aria-label="showPassword ? 'Sembunyikan password' : 'Tampilkan password'"
                            >
                                <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="form-footer">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Ingat saya</label>
                        </div>
                        <a href="#" class="forgot-password">
                            Lupa kata sandi?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="btn-submit"
                        :class="{ 'loading': isLoading }"
                        :disabled="isLoading"
                    >
                        <span x-show="!isLoading">Masuk</span>
                    </button>

                    <!-- Copyright -->
                    <div class="form-footer-copyright">
                        <p>&copy; 2026 <strong>DPUPR Provinsi Banten.</strong> <br>Platform Sistem Informasi Magang. All rights reserved.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function loginApp() {
            return {
                email: '{{ old('email') }}',
                password: '',
                showPassword: false,
                isLoading: false
            }
        }
    </script>
</body>
</html>