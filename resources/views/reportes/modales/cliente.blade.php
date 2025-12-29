<div class="modal fade" id="modalReporteCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-people me-2"></i>Reporte de Clientes</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('clientes.reporte') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Reporte</label>
                        <select class="form-select" name="tipo_reporte" required>
                            <option value="compras_monto">🌟 Top Clientes (Mayor Gasto)</option>
                            <option value="compras_cantidad">📦 Más Productos Comprados</option>
                            <option value="actividad_frecuencia">🔄 Más Activos (Frecuencia)</option>
                            <option value="inactivos">💤 Clientes Inactivos</option>
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

                    <div class="mb-3">
                        <label class="form-label">Mostrar</label>
                        <select class="form-select" name="limite" required>
                            <option value="5">Top 5</option>
                            <option value="10" selected>Top 10</option>
                            <option value="20">Top 20</option>
                            <option value="todos">Todos</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Generar PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>
