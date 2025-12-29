@extends('layouts.guest')

@section('title', 'Iniciar Sesión - SFA')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #0f4c4a 0%, #166866 50%, #1e8582 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    /* Efecto de fondo */
    body::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: moveBackground 20s linear infinite;
    }

    @keyframes moveBackground {
        0% { transform: translate(0, 0); }
        100% { transform: translate(50px, 50px); }
    }

    .login-container {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 450px;
        padding: 20px;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 50px 40px;
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.3),
            0 0 100px rgba(22, 104, 102, 0.2);
        animation: fadeInUp 0.8s ease;
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

    .logo-container {
        text-align: center;
        margin-bottom: 40px;
    }

    .logo {
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
        animation: logoFloat 3s ease-in-out infinite;
    }

    @keyframes logoFloat {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        filter: drop-shadow(0 4px 12px rgba(22, 104, 102, 0.3));
    }

    .welcome-text {
        font-size: 28px;
        font-weight: 700;
        color: #0f4c4a;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .subtitle {
        font-size: 14px;
        color: #6c757d;
        font-weight: 400;
    }

    .form-group {
        margin-bottom: 24px;
        position: relative;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #344054;
        font-size: 14px;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .form-control:focus {
        outline: none;
        border-color: #166866;
        background: white;
        box-shadow: 0 0 0 4px rgba(22, 104, 102, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        background: #fff5f5;
    }

    .invalid-feedback {
        display: block;
        margin-top: 6px;
        font-size: 13px;
        color: #dc3545;
    }

    .btn-login {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #166866 0%, #1e8582 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(22, 104, 102, 0.3);
        margin-top: 8px;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(22, 104, 102, 0.4);
        background: linear-gradient(135deg, #1e8582 0%, #166866 100%);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .alert {
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 24px;
        border: none;
        font-size: 14px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 18px;
        pointer-events: none;
    }

    .form-control-icon {
        padding-left: 46px;
    }

    .password-toggle {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #6c757d;
        cursor: pointer;
        font-size: 18px;
        padding: 0;
        transition: color 0.2s;
    }

    .password-toggle:hover {
        color: #166866;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .login-card {
            padding: 40px 28px;
        }

        .welcome-text {
            font-size: 24px;
        }

        .logo {
            width: 100px;
            height: 100px;
        }
    }
</style>
@endpush

@section('content')
<div class="login-container">
    <div class="login-card">
        <!-- Logo y Título -->
        <div class="logo-container">
            <div class="logo">
                <img src="{{ asset('images/logo/sfa.png') }}" alt="SFA Logo">
            </div>
            <h1 class="welcome-text">Bienvenido</h1>
            <p class="subtitle">Sistema de Facturación Avanzada</p>
        </div>

        <!-- Mensajes -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Usuario -->
            <div class="form-group">
                <label for="login" class="form-label">Usuario</label>
                <div style="position: relative;">
                    <i class="bi bi-person input-icon"></i>
                    <input 
                        type="text" 
                        class="form-control form-control-icon @error('login') is-invalid @enderror" 
                        id="login" 
                        name="login" 
                        value="{{ old('login') }}" 
                        placeholder="Correo, nombre o DNI"
                        required 
                        autocomplete="username"
                        autofocus>
                    @error('login')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Contraseña -->
            <div class="form-group">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label for="password" class="form-label mb-0">Contraseña</label>
                    <a href="{{ route('password.request') }}" style="font-size: 13px; color: #166866; text-decoration: none; font-weight: 500;">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
                <div style="position: relative;">
                    <i class="bi bi-lock input-icon"></i>
                    <input 
                        type="password" 
                        class="form-control form-control-icon @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        placeholder="Ingresa tu contraseña"
                        required 
                        autocomplete="current-password">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Botón -->
            <button type="submit" class="btn-login">
                Iniciar Sesión
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        }
    }
</script>

<!-- Animación del logo (opcional) -->
<script src="{{ asset('js/animacion-logo.js') }}"></script>
@endpush
