@extends('layouts.app')

@section('title', 'Gestión de Ventas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Ventas</h2>
        <a href="{{ route('facturas.create') }}" class="btn btn-primary">
            <i class="bi bi-cart-plus"></i> Nueva Venta
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('ventas.index') }}" class="row g-3">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="search" placeholder="Buscar por Nro, Cliente..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
                <div class="col-md-2">
                    <select name="sort_by" class="form-select" onchange="this.form.submit()">
                        <option value="fecha_emision" {{ request('sort_by') == 'fecha_emision' || !request('sort_by') ? 'selected' : '' }}>Orden Reciente</option>
                        <option value="cliente" {{ request('sort_by') == 'cliente' ? 'selected' : '' }}>Nombre (A-Z)</option>
                        <option value="monto" {{ request('sort_by') == 'monto' ? 'selected' : '' }}>Mayor Monto</option>
                        <option value="items" {{ request('sort_by') == 'items' ? 'selected' : '' }}>Más Items</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="direction" class="form-select" onchange="this.form.submit()">
                        <option value="desc" {{ request('direction') == 'desc' || !request('direction') ? 'selected' : '' }}>Descendente</option>
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nro. Venta</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Monto Total</th>
                            <th>Items</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ventas as $venta)
                            <tr onclick="showVentaDetails(this)" 
                                data-nro="{{ $venta->nro_factura }}"
                                data-cliente="{{ $venta->cliente->getNombreCompleto() }}"
                                data-fecha="{{ $venta->fecha_emision }}"
                                data-detalles="{{ json_encode($venta->detalles->map(function($d) {
                                    return [
                                        'descripcion' => $d->articulo->descripcion,
                                        'cantidad' => $d->cantidad,
                                        'precio' => $d->precio_unitario,
                                        'subtotal' => $d->cantidad * $d->precio_unitario
                                    ];
                                })) }}"
                                style="cursor: pointer;">
                                <td><strong>{{ $venta->nro_factura }}</strong></td>
                                <td>{{ $venta->cliente->getNombreCompleto() }}</td>
                                <td>{{ $venta->fecha_emision }}</td>
                                <td class="fw-bold text-success">S/. {{ number_format($venta->total_factura, 2) }}</td>
                                <td><span class="badge bg-secondary">{{ $venta->detalles->count() }} prod.</span></td>
                                <td>
                                    <span class="badge bg-success">Completada</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No se encontraron ventas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <!-- Pagination removed -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Detalles Venta -->
<div class="modal fade" id="modalDetalleVenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-receipt me-2"></i>Detalle de Venta <span id="modalNroVenta"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Cliente:</strong> <span id="modalCliente"></span>
                    </div>
                    <div class="col-md-6 text-end">
                        <strong>Fecha:</strong> <span id="modalFecha"></span>
                    </div>
                </div>
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cant.</th>
                            <th class="text-end">P. Unit</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="modalItemsBody">
                        <!-- JS populated -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showVentaDetails(row) {
    const nro = row.dataset.nro;
    const cliente = row.dataset.cliente;
    const fecha = row.dataset.fecha;
    const detalles = JSON.parse(row.dataset.detalles);

    document.getElementById('modalNroVenta').textContent = nro;
    document.getElementById('modalCliente').textContent = cliente;
    document.getElementById('modalFecha').textContent = fecha;
    
    const tbody = document.getElementById('modalItemsBody');
    tbody.innerHTML = '';

    detalles.forEach(item => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${item.descripcion}</td>
            <td class="text-center">${item.cantidad}</td>
            <td class="text-end">S/. ${parseFloat(item.precio).toFixed(2)}</td>
            <td class="text-end fw-bold">S/. ${parseFloat(item.subtotal).toFixed(2)}</td>
        `;
        tbody.appendChild(tr);
    });

    const modal = new bootstrap.Modal(document.getElementById('modalDetalleVenta'));
    modal.show();
}
</script>
@endpush
