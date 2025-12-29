<!-- Modal de Confirmación Genérico -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <div class="modal-body p-5 text-center">
                <!-- Icono Animado -->
                <div class="mb-4 d-flex justify-content-center">
                    <div id="confirmIconContainer" style="width: 80px; height: 80px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: pulseRed 2s infinite;">
                        <i id="confirmIcon" class="bi bi-exclamation-triangle text-danger" style="font-size: 40px;"></i>
                    </div>
                </div>

                <!-- Título y Mensaje -->
                <h3 id="confirmTitle" class="mb-3 fw-bold text-dark">¿Estás seguro?</h3>
                <p id="confirmMessage" class="text-muted mb-4" style="font-size: 16px;">
                    Esta acción no se puede deshacer.
                </p>

                <!-- Botones -->
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-light px-4 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 12px; min-width: 120px;">
                        Cancelar
                    </button>
                    <button type="button" id="confirmBtn" class="btn btn-danger px-4 py-2 fw-semibold text-white" style="border-radius: 12px; min-width: 120px; box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.4);">
                        Sí, eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulseRed {
        0% { box-shadow: 0 0 0 0 rgba(254, 226, 226, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(254, 226, 226, 0); }
        100% { box-shadow: 0 0 0 0 rgba(254, 226, 226, 0); }
    }
</style>
