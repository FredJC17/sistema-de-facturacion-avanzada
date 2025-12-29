@extends('layouts.guest')

@section('title', 'Nueva Contraseña - SFA')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #0f4c4a 0%, #166866 50%, #1e8582 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .reset-container {
        width: 100%;
        max-width: 450px;
        padding: 20px;
    }

    .reset-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 50px 40px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: fadeInUp 0.8s ease;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .icon-success {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }

    .icon-success i {
        font-size: 48px;
        color: white;
    }

    .title {
        font-size: 26px;
        font-weight: 700;
        color: #0f4c4a;
        margin-bottom: 12px;
        text-align: center;
    }

    .subtitle {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 32px;
        text-align: center;
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
        padding-left: 46px;
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

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 18px;
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

    .password-strength {
        margin-top: 8px;
        font-size: 12px;
    }

    .strength-bar {
        height: 4px;
        background: #e5e7eb;
        border-radius: 2px;
        overflow: hidden;
        margin-top: 4px;
    }

    .strength-fill {
        height: 100%;
        transition: all 0.3s ease;
        width: 0%;
    }
</style>
@endpush

@section('content')
<div class="reset-container">
    <div class="reset-card">
        <div class="icon-success">
            <i class="bi bi-key"></i>
        </div>

        <h1 class="title">Nueva Contraseña</h1>
        <p class="subtitle">
            Ingresa tu nueva contraseña segura
        </p>

        <form method="POST" action="{{ route('password.update') }}" id="resetForm">
            @csrf

            <div class="form-group">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <div style="position: relative;">
                    <i class="bi bi-lock input-icon"></i>
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password" 
                        placeholder="Mínimo 8 caracteres"
                        required>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="password-strength">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <span id="strengthText"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                <div style="position: relative;">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Repite tu contraseña"
                        required>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="bi bi-check-circle me-2"></i>Cambiar contraseña
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const passwordInput = document.getElementById('password');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');

    passwordInput.addEventListener('input', () => {
        const password = passwordInput.value;
        let strength = 0;

        if (password.length >= 8) strength += 25;
        if (password.match(/[a-z]/)) strength += 25;
        if (password.match(/[A-Z]/)) strength += 25;
        if (password.match(/[0-9]/)) strength += 25;

        strengthFill.style.width = strength + '%';

        if (strength === 0) {
            strengthFill.style.background = '';
            strengthText.textContent = '';
        } else if (strength <= 25) {
            strengthFill.style.background = '#ef4444';
            strengthText.textContent = 'Débil';
            strengthText.style.color = '#ef4444';
        } else if (strength <= 50) {
            strengthFill.style.background = '#f59e0b';
            strengthText.textContent = 'Regular';
            strengthText.style.color = '#f59e0b';
        } else if (strength <= 75) {
            strengthFill.style.background = '#3b82f6';
            strengthText.textContent = 'Buena';
            strengthText.style.color = '#3b82f6';
        } else {
            strengthFill.style.background = '#10b981';
            strengthText.textContent = 'Fuerte';
            strengthText.style.color = '#10b981';
        }
    });
</script>
@endpush
