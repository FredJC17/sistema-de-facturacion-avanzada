<div class="modal fade" id="modalReporteVenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="bi bi-cash-coin me-2"></i>Reporte de Ventas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ventas.reporte') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Reporte</label>
                        <select class="form-select" name="tipo_reporte" required>
                            <option value="ventas_periodo">📅 Ingresos por Periodo</option>
                            <option value="promedio_ticket">🎫 Ticket Promedio</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Periodo</label>
                        <select class="form-select periodo-select" name="periodo" required>
                            <option value="dia">Día Específico</option>
                            <option value="semana">Semana</option>
                            <option value="mes" selected>Mes</option>
                            <option value="anio">Año</option>
                            <option value="personalizado">Rango Personalizado</option>
                        </select>
                    </div>

                    @include('reportes.partials.date_inputs')

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info text-white">Generar PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>
