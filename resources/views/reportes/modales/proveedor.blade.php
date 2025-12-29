<div class="modal fade" id="modalReporteProveedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-truck me-2"></i>Reporte de Proveedores</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('proveedores.reporte') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Reporte</label>
                        <select class="form-select" name="tipo_reporte" required>
                            <option value="proveedores_stock">📊 Top Proveedores (Variedad)</option>
                            <option value="proveedores_ubicacion">🌍 Proveedores por Ubicación</option>
                        </select>
                    </div>

                    <!-- Proveedores son snapshots, no periodos usualmente, pero dejamos input por si acaso o hidden -->
                    
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
                    <button type="submit" class="btn btn-success">Generar PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>
