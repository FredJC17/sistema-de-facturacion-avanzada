// ========================================
// ANIMACIÓN DEL LOGO SFA
// Sistema de Facturación Avanzada
// ========================================

/**
 * Animación de expansión del logo (SFA → Sistema de Facturación Avanzada)
 * Se ejecuta al cargar la página de login
 */
function expandirLogo() {
    const logoContainer = document.getElementById('logo-container');
    const logoImg = document.getElementById('logo-img');

    if (!logoContainer || !logoImg) return;

    // Iniciar con logo corto
    logoImg.src = '/images/logo/sfa.png';
    logoContainer.classList.add('logo-collapsed');

    // Después de 500ms, expandir al logo completo
    setTimeout(() => {
        logoImg.src = '/images/logo/sfa_completo.png';
        logoContainer.classList.remove('logo-collapsed');
        logoContainer.classList.add('logo-expanded');
    }, 500);
}

/**
 * Animación de contracción del logo (Sistema de Facturación Avanzada → SFA)
 * Se ejecuta cuando el login es exitoso
 */
function contraerLogo(callback) {
    const logoContainer = document.getElementById('logo-container');
    const logoImg = document.getElementById('logo-img');

    if (!logoContainer || !logoImg) {
        if (callback) callback();
        return;
    }

    // Contraer a logo corto
    logoImg.src = '/images/logo/sfa.png';
    logoContainer.classList.remove('logo-expanded');
    logoContainer.classList.add('logo-collapsed');

    // Esperar a que termine la animación antes de continuar
    setTimeout(() => {
        if (callback) callback();
    }, 1500);
}

/**
 * Interceptar el submit del formulario de login para animar el logo
 */
document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('login-form');

    if (loginForm) {
        // Expandir logo al cargar la página
        expandirLogo();

        // Interceptar el submit para animar antes de enviar
        loginForm.addEventListener('submit', function (e) {
            // Solo animar si no hay errores previos
            const hayErrores = document.querySelector('.alert-danger');

            if (!hayErrores) {
                e.preventDefault();

                // Mostrar indicador de carga
                const btnSubmit = loginForm.querySelector('button[type="submit"]');
                const textoOriginal = btnSubmit.innerHTML;
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Iniciando sesión...';

                // Contraer logo y luego enviar el formulario
                contraerLogo(() => {
                    loginForm.submit();
                });
            }
        });
    }
});

/**
 * Animación de pulso para el logo (opcional, para dashboard)
 */
function pulsarLogo() {
    const logoImg = document.getElementById('logo-dashboard');

    if (logoImg) {
        logoImg.style.animation = 'pulse 2s ease-in-out infinite';
    }
}

// Estilos CSS para las animaciones (se pueden agregar al CSS principal)
const estilosAnimacion = `
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.logo-container {
    transition: all 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-block;
}

.logo-collapsed img {
    max-height: 80px;
    transition: all 1.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.logo-expanded img {
    max-height: 150px;
    transition: all 1.5s cubic-bezier(0.4, 0, 0.2, 1);
}
`;
