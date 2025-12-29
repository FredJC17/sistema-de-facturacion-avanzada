@extends('layouts.guest')

@section('title', '¿Olvidaste tu contraseña? - SFA')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #0f4c4a 0%, #166866 50%, #1e8582 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .password-reset-container {
        width: 100%;
        max-width: 450px;
        padding: 20px;
    }

    .password-reset-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 50px 40px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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

    .back-button {
        display: inline-flex;
        align-items: center;
        color: #166866;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 24px;
        transition: all 0.2s;
    }

    .back-button:hover {
        color: #0f4c4a;
        transform: translateX(-4px);
    }

    .back-button i {
        margin-right: 6px;
    }

    .title {
        font-size: 26px;
        font-weight: 700;
        color: #0f4c4a;
        margin-bottom: 12px;
    }

    .subtitle {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 32px;
        line-height: 1.6;
    }

    .form-group {
        margin-bottom: 24px;
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

    .btn-submit {
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
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(22, 104, 102, 0.4);
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
    }

    .form-control-icon {
        padding-left: 46px;
    }
</style>
@endpush

@section('content')
<div class="password-reset-container">
    <div class="password-reset-card">
        <a href="{{ route('login') }}" class="back-button">
            <i class="bi bi-arrow-left"></i> Volver al login
        </a>

        <h1 class="title">¿Olvidaste tu contraseña?</h1>
        <p class="subtitle">
            Ingresa tu correo electrónico o número de documento y te enviaremos un código de verificación para restablecer tu contraseña.
        </p>

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

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Correo o Documento</label>
                <div style="position: relative;">
                    <i class="bi bi-envelope input-icon"></i>
                    <input 
                        type="text" 
                        class="form-control form-control-icon @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="correo@ejemplo.com o DNI"
                        required 
                        autofocus>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="bi bi-send me-2"></i>Enviar código
            </button>
        </form>
    </div>
</div>
@endsection
