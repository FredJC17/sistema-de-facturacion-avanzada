// ========================================
// SISTEMA DE TEMAS
// Sistema de Facturación Avanzada (SFA)
// ========================================

document.addEventListener('DOMContentLoaded', function () {
    // Cargar tema guardado
    cargarTemaGuardado();

    // Event listeners para los selectores de tema
    const selectoresTema = document.querySelectorAll('.selector-tema');
    selectoresTema.forEach(selector => {
        selector.addEventListener('click', cambiarTema);
    });
});

/**
 * Cargar el tema guardado del usuario
 */
function cargarTemaGuardado() {
    // Primero intentar cargar desde localStorage
    let tema = localStorage.getItem('tema');

    // Si no hay en localStorage, usar el valor del servidor (si existe)
    if (!tema) {
        const temaPorDefecto = document.body.getAttribute('data-tema-usuario');
        tema = temaPorDefecto || 'claro';
    }

    aplicarTema(tema);
}

/**
 * Cambiar entre tema claro y oscuro
 */
function cambiarTema() {
    const temaActual = document.documentElement.getAttribute('data-tema') || 'claro';
    const nuevoTema = temaActual === 'claro' ? 'oscuro' : 'claro';

    aplicarTema(nuevoTema);
    guardarTema(nuevoTema);
}

/**
 * Aplicar el tema al documento
 */
function aplicarTema(tema) {
    document.documentElement.setAttribute('data-tema', tema);

    // Actualizar iconos de los selectores
    actualizarIconosTema(tema);

    // Animación suave
    document.body.style.transition = 'background-color 0.3s ease, color 0.3s ease';
}

/**
 * Actualizar iconos de selectores de tema
 */
function actualizarIconosTema(tema) {
    const iconosSol = document.querySelectorAll('.icono-sol');
    const iconosLuna = document.querySelectorAll('.icono-luna');

    if (tema === 'oscuro') {
        iconosSol.forEach(icono => icono.style.display = 'inline-block');
        iconosLuna.forEach(icono => icono.style.display = 'none');
    } else {
        iconosSol.forEach(icono => icono.style.display = 'none');
        iconosLuna.forEach(icono => icono.style.display = 'inline-block');
    }
}

/**
 * Guardar preferencia de tema
 */
function guardarTema(tema) {
    // Guardar en localStorage
    localStorage.setItem('tema', tema);

    // Enviar al servidor para guardar en BD
    fetch('/configuracion/cambiar-tema', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ tema: tema })
    })
        .catch(error => {
            console.error('Error al guardar tema:', error);
        });
}
