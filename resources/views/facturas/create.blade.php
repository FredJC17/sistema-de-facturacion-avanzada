@extends('layouts.app')

@section('title', 'Crear Venta')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Crear Nueva Venta</h2>
        <a href="{{ route('facturas.index') }}" class="btn btn-secondary">
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
            <form method="POST" action="{{ route('facturas.store') }}" id="facturaForm">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="cod_cliente" class="form-label">Cliente *</label>
                        <select class="form-select" id="cod_cliente" name="cod_cliente" required>
                            <option value="">Seleccione un cliente...</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">
                                    {{ $cliente->getNombreCompleto() }} - {{ $cliente->documento }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <h5 class="mb-3">Artículos</h5>
                <div id="articulosContainer">
                    <div class="row mb-3 articulo-row">
                        <div class="col-md-5">
                            <label class="form-label">Artículo</label>
                            <select class="form-select articulo-select" name="articulos[0][id]" required>
                                <option value="">Seleccione...</option>
                                @foreach($articulos as $articulo)
                                    <option value="{{ $articulo->id }}" data-precio="{{ $articulo->precio_venta }}" data-stock="{{ $articulo->stock }}">
                                        {{ $articulo->descripcion }} (Stock: {{ $articulo->stock }}) - S/. {{ $articulo->precio_venta }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Cantidad</label>
                            <input type="number" class="form-control cantidad-input" name="articulos[0][cantidad]" min="1" value="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Subtotal</label>
                            <input type="text" class="form-control subtotal-display" readonly value="S/. 0.00">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger w-100 remove-articulo" disabled>
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-success mb-4" id="addArticulo">
                    <i class="bi bi-plus-circle"></i> Agregar Artículo
                </button>

                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="card bg-custom-secondary">
                            <div class="card-body">
                                <!-- Subtotal -->
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal:</span>
                                    <strong id="subtotalFactura">S/. 0.00</strong>
                                </div>
                                
                                <!-- IGV 18% -->
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">IGV (18%):</span>
                                    <strong id="igvFactura">S/. 0.00</strong>
                                </div>
                                
                                <hr>
                                
                                <!-- Total -->
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0">Total:</h5>
                                    <h5 class="mb-0" id="totalFactura" style="color: #166866;">S/. 0.00</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-cart-check"></i> Generar Venta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let articuloIndex = 1;

function calculateSubtotal(row) {
    const select = row.querySelector('.articulo-select');
    const cantidad = parseInt(row.querySelector('.cantidad-input').value) || 0;
    const precio = parseFloat(select.options[select.selectedIndex]?.dataset.precio) || 0;
    const subtotal = precio * cantidad;
    row.querySelector('.subtotal-display').value = 'S/. ' + subtotal.toFixed(2);
    calculateTotal();
}

function calculateTotal() {
    let subtotal = 0;
    
    // Calcular subtotal (suma de productos)
    document.querySelectorAll('.articulo-row').forEach(row => {
        const select = row.querySelector('.articulo-select');
        const cantidad = parseInt(row.querySelector('.cantidad-input').value) || 0;
        const precio = parseFloat(select.options[select.selectedIndex]?.dataset.precio) || 0;
        subtotal += precio * cantidad;
    });
    
    // Calcular IGV (18%)
    const igv = subtotal * 0.18;
    
    // Calcular Total (Subtotal + IGV)
    const total = subtotal + igv;
    
    // Mostrar valores con formato
    document.getElementById('subtotalFactura').textContent = 'S/. ' + subtotal.toFixed(2);
    document.getElementById('igvFactura').textContent = 'S/. ' + igv.toFixed(2);
    document.getElementById('totalFactura').textContent = 'S/. ' + total.toFixed(2);
}

document.getElementById('addArticulo').addEventListener('click', function() {
    const container = document.getElementById('articulosContainer');
    const newRow = container.querySelector('.articulo-row').cloneNode(true);
    
    newRow.querySelectorAll('select, input').forEach(input => {
        const name = input.getAttribute('name');
        if (name) {
            input.setAttribute('name', name.replace(/\[\d+\]/, '[' + articuloIndex + ']'));
        }
        if (input.tagName === 'SELECT') {
            input.selectedIndex = 0;
        } else if (input.classList.contains('cantidad-input')) {
            input.value = 1;
        } else if (input.classList.contains('subtotal-display')) {
            input.value = 'S/. 0.00';
        }
    });
    
    newRow.querySelector('.remove-articulo').disabled = false;
    container.appendChild(newRow);
    articuloIndex++;
    
    attachEventListeners(newRow);
});

function attachEventListeners(row) {
    row.querySelector('.articulo-select').addEventListener('change', function() {
        calculateSubtotal(row);
    });
    
    row.querySelector('.cantidad-input').addEventListener('input', function() {
        calculateSubtotal(row);
    });
    
    row.querySelector('.remove-articulo').addEventListener('click', function() {
        row.remove();
        calculateTotal();
    });
}

document.querySelectorAll('.articulo-row').forEach(row => {
    attachEventListeners(row);
});
</script>
@endpush
