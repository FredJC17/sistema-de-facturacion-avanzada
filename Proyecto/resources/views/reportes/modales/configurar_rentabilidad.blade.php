<!-- Modal para Configurar Gráfico de Rentabilidad -->
<div class="modal fade" id="modalConfigurarRentabilidad" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-gear"></i> Configurar Análisis de Rentabilidad
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tipo de Análisis</label>
                    <select class="form-select" id="tipoAnalisisGrafico">
                        <option value="todos" selected>Todos los artículos</option>
                        <option value="personalizados">Artículos personalizados</option>
                    </select>
                </div>

                <div class="mb-3 d-none" id="articulosGraficoContainer">
                    <label class="form-label">Seleccionar Artículos</label>
                    <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                        @foreach(\App\Models\Articulo::orderBy('descripcion')->get() as $articulo)
                            <div class="form-check">
                                <input class="form-check-input articulo-checkbox" type="checkbox" value="{{ $articulo->id }}" id="grafico_art{{ $articulo->id }}">
                                <label class="form-check-label" for="grafico_art{{ $articulo->id }}">
                                    {{ $articulo->descripcion }}
                                    <small class="text-muted">({{ $articulo->tipoArticulo->descripcion_articulo ?? 'N/A' }})</small>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted">Selecciona uno o más artículos para analizar su rentabilidad en el gráfico</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="aplicarConfiguracionGrafico()">Aplicar</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('tipoAnalisisGrafico').addEventListener('change', function() {
    const container = document.getElementById('articulosGraficoContainer');
    if (this.value === 'personalizados') {
        container.classList.remove('d-none');
    } else {
        container.classList.add('d-none');
    }
});

function aplicarConfiguracionGrafico() {
    const tipo = document.getElementById('tipoAnalisisGrafico').value;
    const fechaInicio = document.getElementById('rentabilidadFechaInicio').value;
    const fechaFin = document.getElementById('rentabilidadFechaFin').value;
    
    let articulosSeleccionados = [];
    if (tipo === 'personalizados') {
        const checkboxes = document.querySelectorAll('.articulo-checkbox:checked');
        articulosSeleccionados = Array.from(checkboxes).map(cb => cb.value);
        
        if (articulosSeleccionados.length === 0) {
            alert('Selecciona al menos un artículo');
            return;
        }
    }
    
    // Cerrar modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalConfigurarRentabilidad'));
    modal.hide();
    
    // Actualizar gráfico
    updateRentabilidadChartWithArticles(fechaInicio, fechaFin, articulosSeleccionados);
}
</script>
