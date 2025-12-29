@extends('layouts.guest')

@section('title', 'Código de Verificación - SFA')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #0f4c4a 0%, #166866 50%, #1e8582 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .code-container {
        width: 100%;
        max-width: 450px;
        padding: 20px;
    }

    .code-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        padding: 50px 40px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: fadeInUp 0.8s ease;
        text-align: center;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .icon-container {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #166866 0%, #1e8582 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .icon-container i {
        font-size: 48px;
        color: white;
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
    }

    .code-inputs {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-bottom: 24px;
    }

    .code-input {
        width: 52px;
        height: 60px;
        text-align: center;
        font-size: 24px;
        font-weight: 700;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        background: #f9fafb;
        transition: all 0.3s ease;
    }

    .code-input:focus {
        outline: none;
        border-color: #166866;
        background: white;
        box-shadow: 0 0 0 4px rgba(22, 104, 102, 0.1);
    }

    .resend-section {
        margin-top: 24px;
        padding-top: 24px;
        border-top: 1px solid #e5e7eb;
        font-size: 14px;
        color: #6c757d;
    }

    .resend-link {
        color: #166866;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
    }

    .resend-link:hover {
        text-decoration: underline;
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
</style>
@endpush

@section('content')
<div class="code-container">
    <div class="code-card">
        <div class="icon-container">
            <i class="bi bi-shield-lock"></i>
        </div>

        <h1 class="title">Verifica tu código</h1>
        <p class="subtitle">
            Hemos enviado un código de 6 dígitos a<br>
            <strong>{{ session('email') }}</strong>
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

        <form method="POST" action="{{ route('password.verify') }}" id="codeForm">
            @csrf

            <div class="code-inputs">
                <input type="text" class="code-input" maxlength="1" id="digit1" data-index="0" autocomplete="off">
                <input type="text" class="code-input" maxlength="1" id="digit2" data-index="1" autocomplete="off">
                <input type="text" class="code-input" maxlength="1" id="digit3" data-index="2" autocomplete="off">
                <input type="text" class="code-input" maxlength="1" id="digit4" data-index="3" autocomplete="off">
                <input type="text" class="code-input" maxlength="1" id="digit5" data-index="4" autocomplete="off">
                <input type="text" class="code-input" maxlength="1" id="digit6" data-index="5" autocomplete="off">
            </div>

            <input type="hidden" name="code" id="fullCode">

            <button type="submit" class="btn-submit">
                <i class="bi bi-check-circle me-2"></i>Verificar código
            </button>
        </form>

        <div class="resend-section">
            ¿No recibiste el código?
            <form method="POST" action="{{ route('password.resend') }}" style="display: inline;">
                @csrf
                <button type="submit" class="resend-link" style="background: none; border: none; padding: 0;">
                    Reenviar código
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const inputs = document.querySelectorAll('.code-input');
    
    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value) {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            }
            updateFullCode();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                inputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const paste = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            paste.split('').forEach((char, i) => {
                if (inputs[i]) inputs[i].value = char;
            });
            if (paste.length === 6) inputs[5].focus();
            updateFullCode();
        });
    });

    function updateFullCode() {
        const code = Array.from(inputs).map(input => input.value).join('');
        document.getElementById('fullCode').value = code;
    }

    // Focus primer input al cargar
    inputs[0].focus();
</script>
@endpush
