@extends('layouts.app')

@section('title', 'Crear Devolución')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Crear Nueva Devolución</h2>
        <a href="{{ route('devoluciones.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('devoluciones.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="factura_id" class="form-label">Seleccionar Factura *</label>
                    <select class="form-select" id="factura_id" required>
                        <option value="">Seleccione una factura...</option>
                        @foreach($facturas as $factura)
                            <option value="{{ $factura->id }}">
                                {{ $factura->nro_factura }} - {{ $factura->cliente->getNombreCompleto() }} ({{ $factura->fecha_facturacion }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cod_detallefactura" class="form-label">Artículo *</label>
                    <select class="form-select" id="cod_detallefactura" name="cod_detallefactura" required disabled>
                        <option value="">Primero seleccione una factura...</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad a Devolver *</label>
                    <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
                    <small class="text-muted">Cantidad disponible: <span id="cantidadDisponible">-</span></small>
                </div>

                <div class="mb-3">
                    <label for="motivo" class="form-label">Motivo de la Devolución *</label>
                    <textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Registrar Devolución
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('factura_id').addEventListener('change', function() {
    const facturaId = this.value;
    const detalleSelect = document.getElementById('cod_detallefactura');
    
    if (!facturaId) {
        detalleSelect.disabled = true;
        detalleSelect.innerHTML = '<option value="">Primero seleccione una factura...</option>';
        return;
    }
    
    fetch(`/devoluciones/detalles/${facturaId}`)
        .then(response => response.json())
        .then(data => {
            detalleSelect.innerHTML = '<option value="">Seleccione un artículo...</option>';
            data.forEach(detalle => {
                if (detalle.cantidad_disponible > 0) {
                    const option = document.createElement('option');
                    option.value = detalle.id;
                    option.textContent = `${detalle.articulo.descripcion} (Disponible: ${detalle.cantidad_disponible})`;
                    option.dataset.disponible = detalle.cantidad_disponible;
                    detalleSelect.appendChild(option);
                }
            });
            detalleSelect.disabled = false;
        });
});

document.getElementById('cod_detallefactura').addEventListener('change', function() {
    const disponible = this.options[this.selectedIndex]?.dataset.disponible || 0;
    document.getElementById('cantidadDisponible').textContent = disponible;
    document.getElementById('cantidad').max = disponible;
});
</script>
@endpush
