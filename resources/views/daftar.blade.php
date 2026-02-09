<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pendaftaran Magang SIMAGANG - DPUPR Provinsi Banten">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pendaftaran - SIMAGANG</title>
    
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
            --success-green: #10b981;
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

        .register-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1000px;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .register-card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            display: grid;
            grid-template-columns: 35% 65%;
            min-height: 650px;
        }

        .progress-panel {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.95) 0%, rgba(79, 70, 229, 0.95) 100%),
                        url('{{ asset('image/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            padding: 48px 32px;
            display: flex;
            flex-direction: column;
            color: white;
            position: relative;
        }

        .progress-panel::before {
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
            margin-bottom: 48px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand-logo img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .brand-name {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .brand-subtitle {
            font-size: 12px;
            font-weight: 500;
            opacity: 0.95;
        }

        .progress-steps {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 32px;
            flex: 1;
        }

        .progress-step {
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .progress-step.active .step-circle {
            background: white;
            color: var(--primary-purple);
            border-color: white;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.4);
        }

        .progress-step.completed .step-circle {
            background: var(--success-green);
            border-color: var(--success-green);
        }

        .step-info {
            flex: 1;
        }

        .step-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 4px;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .progress-step.active .step-title {
            opacity: 1;
        }

        .step-desc {
            font-size: 12px;
            opacity: 0.6;
        }

        .form-panel {
            padding: 48px 44px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            max-height: 650px;
        }

        .form-header {
            margin-bottom: 32px;
        }

        .form-header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .form-header h1 {
            font-size: 26px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .form-header p {
            font-size: 14px;
            color: var(--text-gray);
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* Layout khusus untuk jurusan dan kelas (2fr 2fr) */
        .form-row-equal {
            display: grid;
            grid-template-columns: 2fr 2fr;
            gap: 16px;
        }

        .form-input, .form-select {
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

        /* Input uppercase untuk nama institusi */
        .form-input.uppercase {
            text-transform: uppercase;
        }

        .form-input::placeholder {
            color: transparent;
        }

        .form-input:focus, .form-select:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
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

        /* Custom Select Dropdown for Duration (sesuai referensi gambar) */
        .custom-select-wrapper {
            position: relative;
        }

        .custom-select {
            width: 100%;
            padding: 14px 40px 14px 16px;
            font-size: 15px;
            font-family: inherit;
            color: var(--text-dark);
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            cursor: pointer;
            appearance: none;
            transition: all 0.2s ease;
            outline: none;
        }

        .custom-select:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .custom-select-wrapper::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
            pointer-events: none;
            transition: transform 0.2s ease;
        }

        .custom-select:focus + .custom-select-wrapper::after {
            transform: translateY(-50%) rotate(180deg);
        }

        .participants-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 20px;
        }

        .participant-card {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
        }

        .participant-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .participant-number {
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-purple);
        }

        .btn-remove {
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
            border-radius: 6px;
        }

        .btn-remove:hover {
            background: #fee2e2;
        }

        .btn-add {
            width: 100%;
            padding: 14px 20px;
            font-size: 14px;
            font-weight: 600;
            color: var(--primary-purple);
            background: white;
            border: 2px dashed var(--primary-purple);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .btn-add:hover {
            background: #eff6ff;
        }

        /* Radio button styling untuk status peserta */
        .status-radio-group {
            display: flex;
            gap: 12px;
        }

        .status-radio-option {
            flex: 1;
            position: relative;
        }

        .status-radio-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .status-radio-option label {
            display: block;
            padding: 12px 16px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-gray);
            background: white;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .status-radio-option input[type="radio"]:checked + label {
            color: var(--primary-purple);
            background: #eff6ff;
            border-color: var(--primary-purple);
        }

        .status-radio-option label:hover {
            border-color: var(--primary-purple);
        }

        .file-upload-area {
            border: 2px dashed var(--border-color);
            border-radius: 10px;
            padding: 32px 24px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-area:hover {
            border-color: var(--primary-purple);
            background: #eff6ff;
        }

        .file-upload-area.has-file {
            border-color: var(--success-green);
            background: #f0fdf4;
        }

        .file-upload-icon {
            font-size: 48px;
            color: var(--text-light);
            margin-bottom: 16px;
        }

        .file-upload-area.has-file .file-upload-icon {
            color: var(--success-green);
        }

        .file-upload-text {
            font-size: 15px;
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 4px;
        }

        .file-upload-hint {
            font-size: 13px;
            color: var(--text-gray);
        }

        .file-name {
            margin-top: 12px;
            font-size: 14px;
            color: var(--text-dark);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
        }

        .btn {
            flex: 1;
            padding: 14px 24px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            color: white;
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--primary-purple-dark) 100%);
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .btn-secondary {
            color: var(--text-dark);
            background: white;
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: #f8fafc;
        }

        .btn.loading {
            color: transparent;
            pointer-events: none;
        }

        .btn.loading::after {
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

        .copyright-section {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            text-align: center;
        }

        .copyright-text {
            font-size: 13px;
            color: var(--text-gray);
            line-height: 1.6;
        }

        .success-message {
            text-align: center;
            padding: 60px 20px;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: var(--success-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: scaleIn 0.5s ease-out;
        }

        .success-icon i {
            font-size: 40px;
            color: white;
        }

        @keyframes scaleIn {
            from { transform: scale(0); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .success-message h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .success-message p {
            font-size: 15px;
            color: var(--text-gray);
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 32px;
            font-size: 15px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--primary-purple-dark) 100%);
            border: none;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        @media (max-width: 768px) {
            .register-card {
                grid-template-columns: 1fr;
            }
            .progress-panel {
                display: none;
            }
            .form-panel {
                padding: 32px 24px;
                max-height: none;
            }
            .form-row, .form-row-equal {
                grid-template-columns: 1fr;
            }
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body>
    <div class="register-wrapper" x-data="registerApp()" x-cloak>
        <div class="register-card">
            <!-- LEFT PANEL -->
            <div class="progress-panel">
                <div class="brand-section">
                    <div class="brand-logo">
                        <img src="{{ asset('image/ArtiLambang.png') }}" alt="Logo Banten">
                        <div class="brand-text">
                            <div class="brand-name">SIMAGANG</div>
                            <div class="brand-subtitle">Aplikasi Magang DPUPR Provinsi Banten</div>
                        </div>
                    </div>
                </div>

                <div class="progress-steps">
                    <div class="progress-step" :class="{ 'active': currentStep === 1, 'completed': currentStep > 1 }">
                        <div class="step-circle">
                            <span x-show="currentStep <= 1">1</span>
                            <i class="fa-solid fa-check" x-show="currentStep > 1"></i>
                        </div>
                        <div class="step-info">
                            <div class="step-title">Data Institusi</div>
                            <div class="step-desc">Informasi institusi</div>
                        </div>
                    </div>

                    <div class="progress-step" :class="{ 'active': currentStep === 2, 'completed': currentStep > 2 }">
                        <div class="step-circle">
                            <span x-show="currentStep <= 2">2</span>
                            <i class="fa-solid fa-check" x-show="currentStep > 2"></i>
                        </div>
                        <div class="step-info">
                            <div class="step-title">Data Pengajuan</div>
                            <div class="step-desc">Durasi magang</div>
                        </div>
                    </div>

                    <div class="progress-step" :class="{ 'active': currentStep === 3, 'completed': currentStep > 3 }">
                        <div class="step-circle">
                            <span x-show="currentStep <= 3">3</span>
                            <i class="fa-solid fa-check" x-show="currentStep > 3"></i>
                        </div>
                        <div class="step-info">
                            <div class="step-title">Data Peserta</div>
                            <div class="step-desc">Peserta magang</div>
                        </div>
                    </div>

                    <div class="progress-step" :class="{ 'active': currentStep === 4, 'completed': currentStep > 4 }">
                        <div class="step-circle">
                            <span x-show="currentStep <= 4">4</span>
                            <i class="fa-solid fa-check" x-show="currentStep > 4"></i>
                        </div>
                        <div class="step-info">
                            <div class="step-title">Upload Dokumen</div>
                            <div class="step-desc">Surat pengajuan</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL -->
            <div class="form-panel">
                <div x-show="!isSubmitted">
                    <div class="form-header">
                        <div class="form-header-top">
                            <h1 x-text="stepTitles[currentStep - 1]"></h1>
                        </div>
                        <p x-text="stepSubtitles[currentStep - 1]"></p>
                    </div>

                    <!-- STEP 1: Data Institusi -->
                    <div x-show="currentStep === 1" x-transition>
                        <form @submit.prevent="nextStep">
                            <div class="form-group">
                                <input 
                                    type="text" 
                                    id="name"
                                    class="form-input uppercase"
                                    placeholder="Nama Institusi"
                                    x-model="formData.name"
                                    required
                                >
                                <label for="name" class="form-label">Nama Institusi</label>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <input 
                                        type="email" 
                                        id="email"
                                        class="form-input"
                                        placeholder="Email"
                                        x-model="formData.email"
                                        required
                                    >
                                    <label for="email" class="form-label">Email</label>
                                </div>

                                <div class="form-group">
                                    <input 
                                        type="tel" 
                                        id="whatsapp"
                                        class="form-input"
                                        placeholder="Nomor WhatsApp"
                                        x-model="formData.whatsapp"
                                        required
                                    >
                                    <label for="whatsapp" class="form-label">Nomor WhatsApp</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="password-wrapper">
                                    <input 
                                        :type="showPassword ? 'text' : 'password'"
                                        id="password"
                                        class="form-input"
                                        placeholder="Password"
                                        x-model="formData.password"
                                        minlength="6"
                                        required
                                    >
                                    <label for="password" class="form-label">Password</label>
                                    <button 
                                        type="button"
                                        class="toggle-password"
                                        @click="showPassword = !showPassword"
                                    >
                                        <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="password-wrapper">
                                    <input 
                                        :type="showConfirmPassword ? 'text' : 'password'"
                                        id="password_confirmation"
                                        class="form-input"
                                        placeholder="Konfirmasi Password"
                                        x-model="formData.password_confirmation"
                                        required
                                    >
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <button 
                                        type="button"
                                        class="toggle-password"
                                        @click="showConfirmPassword = !showConfirmPassword"
                                    >
                                        <i :class="showConfirmPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    Lanjutkan
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <div class="copyright-section">
                                <p class="copyright-text">
                                    &copy; 2026 <strong>DPUPR Provinsi Banten</strong><br>
                                    Platform Sistem Informasi Magang. All rights reserved.
                                </p>
                            </div>
                        </form>
                    </div>

                    <!-- STEP 2: Data Pengajuan (Dropdown sesuai gambar) -->
                    <div x-show="currentStep === 2" x-transition>
                        <form @submit.prevent="nextStep">
                            <div class="form-group">
                                <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 12px;">
                                    Durasi Magang
                                </label>
                                <div class="custom-select-wrapper">
                                    <select 
                                        id="duration"
                                        class="custom-select"
                                        x-model="formData.duration_month"
                                        required
                                    >
                                        <option value="" disabled selected>Pilih Durasi</option>
                                        <option value="1">1 Bulan</option>
                                        <option value="2">2 Bulan</option>
                                        <option value="3">3 Bulan</option>
                                        <option value="6">6 Bulan</option>
                                        <option value="9">9 Bulan</option>
                                        <option value="12">12 Bulan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary" @click="previousStep">
                                    <i class="fa-solid fa-arrow-left"></i>
                                    Kembali
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Lanjutkan
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <div class="copyright-section">
                                <p class="copyright-text">
                                    &copy; 2026 <strong>DPUPR Provinsi Banten</strong><br>
                                    Platform Sistem Informasi Magang. All rights reserved.
                                </p>
                            </div>
                        </form>
                    </div>

                    <!-- STEP 3: Data Peserta -->
                    <div x-show="currentStep === 3" x-transition>
                        <form @submit.prevent="nextStep">
                            <div class="participants-list">
                                <template x-for="(participant, index) in formData.participants" :key="index">
                                    <div class="participant-card">
                                        <div class="participant-header">
                                            <span class="participant-number">Peserta <span x-text="index + 1"></span></span>
                                            <button 
                                                type="button" 
                                                class="btn-remove"
                                                @click="removeParticipant(index)"
                                                x-show="formData.participants.length > 1"
                                            >
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                        </div>

                                        <div class="form-group">
                                            <input 
                                                type="text" 
                                                :id="'name_' + index"
                                                class="form-input uppercase"
                                                placeholder="Nama Lengkap"
                                                x-model="participant.name"
                                                required
                                            >
                                            <label :for="'name_' + index" class="form-label">Nama Lengkap</label>
                                        </div>

                                        <div class="form-group">
                                            <label style="display: block; font-size: 13px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">
                                                Status Peserta
                                            </label>
                                            <div class="status-radio-group">
                                                <div class="status-radio-option">
                                                    <input type="radio" :id="'siswa_' + index" :name="'status_' + index" value="SISWA" x-model="participant.participant_type" required>
                                                    <label :for="'siswa_' + index">
                                                        <i class="fa-solid fa-user-graduate"></i> Siswa
                                                    </label>
                                                </div>
                                                <div class="status-radio-option">
                                                    <input type="radio" :id="'mahasiswa_' + index" :name="'status_' + index" value="MAHASISWA" x-model="participant.participant_type" required>
                                                    <label :for="'mahasiswa_' + index">
                                                        <i class="fa-solid fa-graduation-cap"></i> Mahasiswa
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input 
                                                type="text" 
                                                :id="'identity_number_' + index"
                                                class="form-input uppercase"
                                                :placeholder="participant.participant_type === 'SISWA' ? 'NISN' : 'NIM'"
                                                x-model="participant.identity_number"
                                                maxlength="15"
                                                required
                                            >
                                            <label :for="'identity_number_' + index" class="form-label" x-text="participant.participant_type === 'SISWA' ? 'NISN' : 'NIM'"></label>
                                        </div>

                                        <!-- Mode SISWA: Jurusan dan Kelas Flex Kanan-Kiri -->
                                        <div x-show="participant.participant_type === 'SISWA'">
                                            <div class="form-row-equal">
                                                <div class="form-group">
                                                    <input 
                                                        type="text" 
                                                        :id="'major_' + index"
                                                        class="form-input uppercase"
                                                        placeholder="Jurusan"
                                                        x-model="participant.major"
                                                        required
                                                    >
                                                    <label :for="'major_' + index" class="form-label">Jurusan</label>
                                                </div>

                                                <div class="form-group">
                                                    <input 
                                                        type="text" 
                                                        :id="'class_or_program_' + index"
                                                        class="form-input uppercase"
                                                        placeholder="Kelas"
                                                        x-model="participant.class_or_program"
                                                    >
                                                    <label :for="'class_or_program_' + index" class="form-label">Kelas</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Mode MAHASISWA: Jurusan Full Width, Program Studi dan Semester Flex -->
                                        <div x-show="participant.participant_type === 'MAHASISWA'">
                                            <div class="form-group">
                                                <input 
                                                    type="text" 
                                                    :id="'major_mhs_' + index"
                                                    class="form-input uppercase"
                                                    placeholder="Jurusan"
                                                    x-model="participant.major"
                                                    required
                                                >
                                                <label :for="'major_mhs_' + index" class="form-label">Jurusan</label>
                                            </div>

                                            <div class="form-row-equal">
                                                <div class="form-group">
                                                    <input 
                                                        type="text" 
                                                        :id="'class_or_program_mhs_' + index"
                                                        class="form-input uppercase"
                                                        placeholder="Program Studi"
                                                        x-model="participant.class_or_program"
                                                    >
                                                    <label :for="'class_or_program_mhs_' + index" class="form-label">Program Studi</label>
                                                </div>

                                                <div class="form-group">
                                                    <input 
                                                        type="number" 
                                                        :id="'semester_' + index"
                                                        class="form-input"
                                                        placeholder="Semester"
                                                        x-model="participant.semester"
                                                        min="1"
                                                        max="14"
                                                    >
                                                    <label :for="'semester_' + index" class="form-label">Semester</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <button 
                                type="button" 
                                class="btn-add"
                                @click="addParticipant"
                            >
                                <i class="fa-solid fa-plus"></i>
                                Tambah Peserta Lainnya
                            </button>

                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary" @click="previousStep">
                                    <i class="fa-solid fa-arrow-left"></i>
                                    Kembali
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    Lanjutkan
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>

                            <div class="copyright-section">
                                <p class="copyright-text">
                                    &copy; 2026 <strong>DPUPR Provinsi Banten</strong><br>
                                    Platform Sistem Informasi Magang. All rights reserved.
                                </p>
                            </div>
                        </form>
                    </div>

                    <!-- STEP 4: Upload Dokumen -->
                    <div x-show="currentStep === 4" x-transition>
                        <form @submit.prevent="submitForm">
                            <div class="form-group" style="margin-bottom: 16px;">
                                <label style="display: block; font-size: 14px; font-weight: 600; color: var(--text-dark); margin-bottom: 8px;">
                                    Upload Surat Pengajuan Resmi
                                </label>
                                <p style="font-size: 13px; color: var(--text-gray); margin-bottom: 16px;">
                                    Surat pengajuan dari institusi yang ditujukan ke DPUPR Provinsi Banten
                                </p>

                                <div 
                                    class="file-upload-area"
                                    :class="{ 'has-file': formData.document }"
                                    @click="$refs.fileInput.click()"
                                >
                                    <input 
                                        type="file" 
                                        style="position: absolute; opacity: 0;"
                                        x-ref="fileInput"
                                        accept=".pdf"
                                        @change="handleFileUpload"
                                        required
                                    >
                                    <div class="file-upload-icon">
                                        <i :class="formData.document ? 'fa-solid fa-file-pdf' : 'fa-solid fa-cloud-arrow-up'"></i>
                                    </div>
                                    <p class="file-upload-text" x-text="formData.document ? 'Dokumen Terpilih' : 'Klik untuk Upload'"></p>
                                    <p class="file-upload-hint">Format: PDF (Maksimal 5MB)</p>
                                    <div class="file-name" x-show="formData.document">
                                        <i class="fa-solid fa-file-pdf"></i>
                                        <span x-text="formData.documentName"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary" @click="previousStep">
                                    <i class="fa-solid fa-arrow-left"></i>
                                    Kembali
                                </button>
                                <button 
                                    type="submit" 
                                    class="btn btn-primary"
                                    :class="{ 'loading': isLoading }"
                                    :disabled="isLoading"
                                >
                                    <span x-show="!isLoading">
                                        Kirim Pengajuan
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </span>
                                </button>
                            </div>

                            <div class="copyright-section">
                                <p class="copyright-text">
                                    &copy; 2026 <strong>DPUPR Provinsi Banten</strong><br>
                                    Platform Sistem Informasi Magang. All rights reserved.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Success Message -->
                <div x-show="isSubmitted" x-transition>
                    <div class="success-message">
                        <div class="success-icon">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <h2>Pengajuan Berhasil Dikirim!</h2>
                        <p>
                            Terima kasih telah mendaftar. Pengajuan magang Anda telah kami terima dan akan segera diproses oleh tim DPUPR Provinsi Banten.
                        </p>
                        <a href="{{ route('login') }}" class="btn-back">
                            <i class="fa-solid fa-arrow-left"></i>
                            Kembali ke Login
                        </a>

                        <div class="copyright-section">
                            <p class="copyright-text">
                                &copy; 2026 <strong>DPUPR Provinsi Banten</strong><br>
                                Platform Sistem Informasi Magang. All rights reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function registerApp() {
            return {
                currentStep: 1,
                isLoading: false,
                isSubmitted: false,
                showPassword: false,
                showConfirmPassword: false,

                stepTitles: [
                    'Data Institusi',
                    'Data Pengajuan Magang',
                    'Data Peserta Magang',
                    'Upload Dokumen Resmi'
                ],
                stepSubtitles: [
                    'Lengkapi informasi institusi Anda',
                    'Pilih durasi pelaksanaan magang',
                    'Masukkan data lengkap peserta magang',
                    'Upload surat pengajuan resmi dari institusi'
                ],

                formData: {
                    name: '',
                    email: '',
                    whatsapp: '',
                    password: '',
                    password_confirmation: '',
                    duration_month: '',
                    participants: [
                        { 
                            name: '', 
                            participant_type: 'SISWA', 
                            identity_number: '', 
                            major: '', 
                            class_or_program: '', 
                            semester: null 
                        }
                    ],
                    document: null,
                    documentName: ''
                },

                nextStep() {
                    // Validasi Step 1
                    if (this.currentStep === 1) {
                        // Uppercase otomatis nama institusi
                        this.formData.name = this.formData.name.toUpperCase();
                        
                        if (this.formData.password !== this.formData.password_confirmation) {
                            alert('Password dan konfirmasi password tidak sama!');
                            return;
                        }
                        if (this.formData.password.length < 6) {
                            alert('Password minimal 6 karakter!');
                            return;
                        }
                    }

                    // Validasi Step 2
                    if (this.currentStep === 2) {
                        if (!this.formData.duration_month) {
                            alert('Pilih durasi magang!');
                            return;
                        }
                    }

                    // Validasi Step 3
                    if (this.currentStep === 3) {
                        for (let i = 0; i < this.formData.participants.length; i++) {
                            const p = this.formData.participants[i];
                            
                            // Uppercase otomatis
                            p.name = p.name.toUpperCase();
                            p.identity_number = p.identity_number.toUpperCase();
                            p.major = p.major.toUpperCase();
                            if (p.class_or_program) {
                                p.class_or_program = p.class_or_program.toUpperCase();
                            }
                            
                            // Validasi maxlength NISN/NIM
                            if (p.identity_number.length > 15) {
                                alert(`NISN atau NIM peserta ${i + 1} maksimal 15 karakter!`);
                                return;
                            }
                            
                            if (!p.name || !p.participant_type || !p.identity_number || !p.major) {
                                alert(`Data peserta ${i + 1} belum lengkap!`);
                                return;
                            }
                        }
                    }

                    if (this.currentStep < 4) {
                        this.currentStep++;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },

                previousStep() {
                    if (this.currentStep > 1) {
                        this.currentStep--;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                },

                addParticipant() {
                    this.formData.participants.push({
                        name: '',
                        participant_type: 'SISWA',
                        identity_number: '',
                        major: '',
                        class_or_program: '',
                        semester: null
                    });
                },

                removeParticipant(index) {
                    if (this.formData.participants.length > 1) {
                        if (confirm('Hapus data peserta ini?')) {
                            this.formData.participants.splice(index, 1);
                        }
                    }
                },

                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        if (file.type !== 'application/pdf') {
                            alert('File harus berformat PDF!');
                            event.target.value = '';
                            return;
                        }
                        if (file.size > 5 * 1024 * 1024) {
                            alert('Ukuran file maksimal 5MB!');
                            event.target.value = '';
                            return;
                        }
                        this.formData.document = file;
                        this.formData.documentName = file.name;
                    }
                },

                async submitForm() {
                    if (!confirm(`Kirim pengajuan untuk ${this.formData.participants.length} peserta?`)) {
                        return;
                    }

                    this.isLoading = true;

                    // Simulate submission
                    setTimeout(() => {
                        this.isLoading = false;
                        this.isSubmitted = true;
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }, 2000);
                }
            }
        }
    </script>
</body>
</html>
