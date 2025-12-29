/**
 * Helper para mostrar el modal de confirmación
 * 
 * @param {Object} options Configuración del modal
 * @param {string} options.title Título del modal
 * @param {string} options.message Mensaje explicativo
 * @param {string} options.type Tipo 'danger' (eliminar), 'warning' (desactivar), 'success' (activar)
 * @param {string} options.formId ID del formulario a enviar al confirmar
 * @param {Function} options.callback Función a ejecutar si no hay formId
 * @param {string} options.buttonText Texto del botón de confirmación
 */
function showConfirmModal(options) {
    const modalElement = document.getElementById('confirmModal');
    const modal = new bootstrap.Modal(modalElement);

    // Elementos del DOM
    const titleEl = document.getElementById('confirmTitle');
    const messageEl = document.getElementById('confirmMessage');
    const btnEl = document.getElementById('confirmBtn');
    const iconContainer = document.getElementById('confirmIconContainer');
    const icon = document.getElementById('confirmIcon');

    // Configuración por tipo
    let colors = {
        danger: { bg: '#fee2e2', text: 'text-danger', btn: 'btn-danger', shadow: 'rgba(220, 38, 38, 0.4)', icon: 'bi-trash3' },
        warning: { bg: '#fef3c7', text: 'text-warning', btn: 'btn-warning', shadow: 'rgba(217, 119, 6, 0.4)', icon: 'bi-exclamation-triangle' },
        success: { bg: '#d1fae5', text: 'text-success', btn: 'btn-success', shadow: 'rgba(5, 150, 105, 0.4)', icon: 'bi-check-lg' },
        info: { bg: '#e0f2fe', text: 'text-info', btn: 'btn-info', shadow: 'rgba(8, 145, 178, 0.4)', icon: 'bi-info-circle' }
    };

    const type = options.type || 'danger';
    const conf = colors[type];

    // Aplicar estilos
    titleEl.innerText = options.title || '¿Estás seguro?';
    messageEl.innerText = options.message || 'Esta acción no se puede deshacer.';

    // Resetear clases
    iconContainer.style.background = conf.bg;
    iconContainer.className = 'mb-4 d-flex justify-content-center'; // Reset animation class if needed (managed by ID usually)

    icon.className = `bi ${conf.icon} ${conf.text}`;

    btnEl.className = `btn ${conf.btn} px-4 py-2 fw-semibold text-white`;
    btnEl.style.boxShadow = `0 4px 12px ${conf.shadow}`;
    btnEl.innerText = options.buttonText || (type === 'danger' ? 'Sí, eliminar' : 'Confirmar');

    // Manejar evento click
    btnEl.onclick = function () {
        if (options.formId) {
            document.getElementById(options.formId).submit();
        } else if (typeof options.callback === 'function') {
            options.callback();
        }
        modal.hide();
    };

    modal.show();
}

// Hacer disponible globalmente
window.showConfirmModal = showConfirmModal;
