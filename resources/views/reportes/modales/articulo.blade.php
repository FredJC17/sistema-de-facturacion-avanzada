<div class="modal fade" id="modalReporteArticulo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="bi bi-box-seam me-2"></i>Reporte de Artículos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('articulos.reporte') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Reporte</label>
                        <select class="form-select" name="tipo_reporte" required>
                            <option value="stock_bajo">⚠️ Stock Crítico (<= 10)</option>
                            <option value="mas_vendidos">🔥 Artículos Más Vendidos</option>
                            <option value="valor_inventario">💰 Valoración de Inventario</option>
                        </select>
                    </div>

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
                    <button type="submit" class="btn btn-warning">Generar PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>
