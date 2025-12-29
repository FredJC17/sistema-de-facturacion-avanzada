<!-- Modal para Reporte de Rentabilidad -->
<div class="modal fade" id="modalReporteRentabilidad" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-graph-up"></i> Reporte de Rentabilidad
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('reportes.rentabilidad.generar') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Rango de Fechas</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="fecha_inicio" required>
                                <small class="text-muted">Fecha inicio</small>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" name="fecha_fin" required>
                                <small class="text-muted">Fecha fin</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo de Análisis</label>
                        <select class="form-select" name="tipo_analisis" id="tipoAnalisisSelect">
                            <option value="todos">Todos los artículos</option>
                            <option value="personalizados">Artículos personalizados</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="articulosPersonalizadosContainer">
                        <label class="form-label">Seleccionar Artículos</label>
                        <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                            @foreach(\App\Models\Articulo::orderBy('descripcion')->get() as $articulo)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="articulos[]" value="{{ $articulo->id }}" id="art{{ $articulo->id }}">
                                    <label class="form-check-label" for="art{{ $articulo->id }}">
                                        {{ $articulo->descripcion }}
                                        <small class="text-muted">({{ $articulo->tipoArticulo->descripcion_articulo ?? 'N/A' }})</small>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted">Selecciona uno o más artículos para analizar su rentabilidad</small>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-file-earmark-pdf"></i> Generar Reporte PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('tipoAnalisisSelect').addEventListener('change', function() {
    const container = document.getElementById('articulosPersonalizadosContainer');
    if (this.value === 'personalizados') {
        container.classList.remove('d-none');
    } else {
        container.classList.add('d-none');
    }
});
</script>
