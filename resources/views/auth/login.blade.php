@php
    use App\Models\Setting;

    $appName = Setting::get('app_name', 'Laboratorium Kesehatan');
    $logo = Setting::get('app_logo');
    $background = Setting::get('login_background');
    $primaryColor = Setting::get('primary_color', '#004b23');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ $appName }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        /* Background dengan overlay lebih gelap agar logo putih kontras */
        .login-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            @if($background && Storage::disk('public')->exists($background))
                background-image: url('{{ Storage::url($background) }}');
            @else
                background-image: url('https://images.unsplash.com/photo-1579154204601-0150f4e6d3b0?q=80&w=2070');
            @endif
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .login-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $primaryColor }}dd 100%);
            opacity: 0.40;
        }

        .login-container {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-card {
            background: white;
            border-radius: 32px;
            width: 100%;
            max-width: 460px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header dengan background putih bersih */
        .login-header {
            background: white;
            padding: 2rem 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid #f0f0f0;
        }

        /* Container logo - area putih untuk logo */
        .logo-container {
            background: white;
            padding: 1px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1rem;
        }

        .login-logo {
            width: 140px;
            height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 24px;
        }

        .login-logo img {
            max-width: 270px;
            max-height: 270px;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .login-logo i {
            font-size: 4rem;
            color: {{ $primaryColor }};
        }

        .login-header h2 {
            color: #1a1a1a;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.3px;
            margin-bottom: 0.25rem;
        }

        .login-header p {
            color: #6b7280;
            font-size: 0.8rem;
        }

        .login-form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            border: 1.5px solid #e5e7eb;
            border-radius: 14px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s;
            font-weight: 500;
        }

        .form-input:focus {
            border-color: {{ $primaryColor }};
            box-shadow: 0 0 0 3px {{ $primaryColor }}20;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            font-size: 1rem;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: #4b5563;
            cursor: pointer;
        }

        .checkbox-label input {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: {{ $primaryColor }};
        }

        .btn-login {
            width: 100%;
            background: {{ $primaryColor }};
            color: white;
            border: none;
            padding: 0.875rem;
            border-radius: 14px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            background: {{ $primaryColor }}dd;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px {{ $primaryColor }}40;
        }

        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 14px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-message i {
            color: #dc2626;
            font-size: 1rem;
        }

        .error-message span {
            color: #991b1b;
            font-size: 0.8rem;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 14px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-success i {
            color: #16a34a;
        }

        .alert-success span {
            color: #166534;
            font-size: 0.8rem;
        }

        .login-footer {
            text-align: center;
            padding: 1rem 2rem 1.5rem;
            border-top: 1px solid #f0f0f0;
            background: #fafafa;
        }

        .login-footer p {
            font-size: 0.7rem;
            color: #6b7280;
        }

        .login-footer i {
            margin-right: 0.25rem;
        }

        /* ========== RESPONSIVE MOBILE ONLY ========== */
        /* Tablet (768px - 1024px) - Penyesuaian ringan */
        @media (max-width: 768px) {
            .login-container {
                padding: 4px;
            }

            .login-card {
                max-width: 420px;
            }

            .login-header {
                padding: 1.5rem 1.5rem 1rem;
            }

            .login-logo {
                width: 110px;
                height: 110px;
            }

            .login-logo img {
                max-width: 150px;
                max-height: 150px;
            }

            .login-logo i {
                font-size: 3rem;
            }

            .login-header h2 {
                font-size: 1.35rem;
            }

            .login-form {
                padding: 1.5rem;
            }
        }

        /* Mobile Landscape (480px - 768px) */
        @media (max-width: 480px) {
            .login-container {
                padding: 1rem;
            }

            .login-card {
                max-width: 100%;
                border-radius: 28px;
            }

            .login-header {
                padding: 1.25rem 1.25rem 0.75rem;
            }

            .logo-container {
                margin-bottom: 0.5rem;
            }

            .login-logo {
                width: 80px;
                height: 80px;
            }

            .login-logo img {
                max-width: 180px;
                max-height: 180px;
            }

            .login-logo i {
                font-size: 2.5rem;
            }

            .login-header h2 {
                font-size: 1.1rem;
            }

            .login-header p {
                font-size: 0.7rem;
            }

            .login-form {
                padding: 1.25rem;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .form-label {
                font-size: 0.75rem;
                margin-bottom: 0.35rem;
            }

            .form-input {
                padding: 0.7rem 0.8rem 0.7rem 2.5rem;
                font-size: 0.85rem;
                border-radius: 12px;
            }

            .input-icon {
                left: 0.8rem;
                font-size: 0.9rem;
            }

            .password-toggle {
                right: 0.8rem;
                font-size: 0.9rem;
            }

            .checkbox-label {
                font-size: 0.75rem;
            }

            .btn-login {
                padding: 0.7rem;
                font-size: 0.85rem;
                border-radius: 12px;
            }

            .error-message, .alert-success {
                padding: 0.6rem 0.8rem;
                margin-bottom: 1rem;
                border-radius: 12px;
            }

            .error-message span, .alert-success span {
                font-size: 0.75rem;
            }

            .login-footer {
                padding: 0.75rem 1.25rem 1rem;
            }

            .login-footer p {
                font-size: 0.65rem;
            }
        }

        /* Mobile Portrait (max 375px) - iPhone SE, Galaxy kecil */
        @media (max-width: 375px) {
            .login-header {
                padding: 1rem 1rem 0.5rem;
            }

            .login-logo {
                width: 70px;
                height: 70px;
            }

            .login-logo img {
                max-width: 55px;
                max-height: 55px;
            }

            .login-logo i {
                font-size: 2rem;
            }

            .login-header h2 {
                font-size: 1rem;
            }

            .login-header p {
                font-size: 0.65rem;
            }

            .login-form {
                padding: 1rem;
            }

            .form-input {
                padding: 0.6rem 0.7rem 0.6rem 2.2rem;
                font-size: 0.8rem;
            }

            .btn-login {
                padding: 0.6rem;
                font-size: 0.8rem;
            }
        }

        /* Landscape orientation on mobile */
        @media (max-width: 768px) and (orientation: landscape) {
            .login-container {
                padding: 0.5rem;
                align-items: center;
            }

            .login-card {
                max-width: 400px;
            }

            .login-header {
                padding: 0.75rem 1rem 0.5rem;
            }

            .login-logo {
                width: 60px;
                height: 60px;
            }

            .login-logo img {
                max-width: 45px;
                max-height: 45px;
            }

            .login-logo i {
                font-size: 1.75rem;
            }

            .login-header h2 {
                font-size: 1rem;
            }

            .login-header p {
                font-size: 0.65rem;
            }

            .login-form {
                padding: 0.75rem 1rem;
            }

            .form-group {
                margin-bottom: 0.75rem;
            }

            .form-input {
                padding: 0.5rem 0.7rem 0.5rem 2rem;
                font-size: 0.8rem;
            }

            .btn-login {
                padding: 0.5rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-bg"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-container">
                    <div class="login-logo">
                        @if($logo && Storage::disk('public')->exists($logo))
                            <img src="{{ Storage::url($logo) }}" alt="{{ $appName }}">
                        @else
                            <i class="fas fa-flask"></i>
                        @endif
                    </div>
                </div>
                <h2>{{ $appName }}</h2>
                <p>Sistem Informasi Manajemen Laboratorium Kesehatan</p>
            </div>

            <div class="login-form">
                @if ($errors->any())
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">NIP / Username</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="nip" value="{{ old('nip') }}" required autofocus
                                   class="form-input" placeholder="Masukkan NIP">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" id="password" required
                                   class="form-input" placeholder="Masukkan password">
                            <button type="button" id="togglePassword" class="password-toggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="checkbox-wrapper">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember">
                            <span>Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Masuk ke Dashboard</span>
                    </button>
                </form>
            </div>

            <div class="login-footer">

                <p style="margin-top: 0.5rem; font-size: 0.65rem;">
                    &copy; {{ date('Y') }} {{ $appName }}. All rights reserved.
                </p>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
    </script>
</body>
</html>
