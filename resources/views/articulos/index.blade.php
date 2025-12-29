@extends('layouts.app')

@section('title', 'Artículos')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Artículos</h2>
        <div>
            <a href="{{ route('facturas.create') }}" class="btn btn-success me-2">
                <i class="bi bi-cart-plus"></i> Nueva Venta
            </a>
            <a href="{{ route('articulos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Artículo
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('articulos.index') }}" class="row g-3">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="search" placeholder="Buscar por descripción, tipo o proveedor..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="sort_by" onchange="this.form.submit()">
                        <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Más recientes</option>
                        <option value="ventas" {{ request('sort_by') == 'ventas' ? 'selected' : '' }}>Más vendidos</option>
                        <option value="stock" {{ request('sort_by') == 'stock' ? 'selected' : '' }}>Por stock</option>
                        <option value="precio" {{ request('sort_by') == 'precio' ? 'selected' : '' }}>Por precio</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="sort_order" onchange="this.form.submit()">
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descendente</option>
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Proveedor</th>
                            <th>Precio Costo</th>
                            <th>Precio Venta</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articulos as $articulo)
                            <tr onclick="showArticleDetails(this)" 
                                data-json="{{ json_encode([
                                    'Descripción' => $articulo->descripcion,
                                    'Tipo' => $articulo->tipoArticulo->descripcion_articulo,
                                    'Proveedor' => $articulo->proveedor->getNombreCompleto(),
                                    'Precio Costo' => 'S/. ' . number_format($articulo->precio_costo, 2),
                                    'Precio Venta' => 'S/. ' . number_format($articulo->precio_venta, 2),
                                    'Stock Actual' => $articulo->stock,
                                    'Valor Inventario' => 'S/. ' . number_format($articulo->stock * $articulo->precio_costo, 2),
                                    'Estado' => ucfirst($articulo->estado)
                                ]) }}"
                                style="cursor: pointer;">
                                <td>{{ $articulo->descripcion }}</td>
                                <td>{{ $articulo->tipoArticulo->descripcion_articulo }}</td>
                                <td>{{ $articulo->proveedor->getNombreCompleto() }}</td>
                                <td>S/. {{ number_format($articulo->precio_costo, 2) }}</td>
                                <td>S/. {{ number_format($articulo->precio_venta, 2) }}</td>
                                <td>
                                    @if($articulo->stock <= 5)
                                        <span class="badge badge-low-stock">{{ $articulo->stock }}</span>
                                    @elseif($articulo->stock <= 10)
                                        <span class="badge badge-medium-stock">{{ $articulo->stock }}</span>
                                    @else
                                        <span class="badge badge-good-stock">{{ $articulo->stock }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{!! \App\Helpers\FormatoHelper::badgeEstado($articulo->estado) !!}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-success me-1" 
                                            onclick="openRestockModal('{{ $articulo->id }}', '{{ $articulo->descripcion }}', '{{ $articulo->precio_costo }}', '{{ $articulo->precio_venta }}'); event.stopPropagation();"
                                            title="Reabastecer Stock">
                                        <i class="bi bi-box-arrow-in-down"></i>
                                    </button>
                                    <a href="{{ route('articulos.edit', $articulo) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($articulo->estaActivo())
                                        <form id="delete-form-{{ $articulo->id }}" action="{{ route('articulos.destroy', $articulo) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="showConfirmModal({
                                                    title: '¿Desactivar artículo?',
                                                    message: 'Se desactivará el artículo {{ $articulo->descripcion }}.',
                                                    type: 'danger',
                                                    formId: 'delete-form-{{ $articulo->id }}'
                                                })">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form id="activate-form-{{ $articulo->id }}" action="{{ route('articulos.activate', $articulo) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="showConfirmModal({
                                                    title: '¿Activar artículo?',
                                                    message: 'Se habilitará nuevamente el artículo {{ $articulo->descripcion }}.',
                                                    type: 'success',
                                                    buttonText: 'Activar',
                                                    formId: 'activate-form-{{ $articulo->id }}'
                                                })">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No se encontraron artículos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $articulos->links() }}
            </div>
        </div>
    </div>
</div>
</div>
@endsection

<!-- Modal Detalles Artículo -->
<div class="modal fade" id="modalDetalleArticulo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="bi bi-box-seam me-2"></i>Detalles del Artículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tbody id="detalleArticuloBody"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reabastecer Stock -->
<div class="modal fade" id="modalReabastecer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-box-arrow-in-down me-2"></i>Reabastecer Artículo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('compras.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="cod_articulo" id="restock_cod_articulo">
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-1"></i> Está agregando stock para: <strong id="restock_nombre_articulo"></strong>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cantidad a Agregar <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="cantidad" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de Compra <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="fecha_compra" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nuevo Precio Compra</label>
                            <div class="input-group">
                                <span class="input-group-text">S/.</span>
                                <input type="number" step="0.01" class="form-control" name="precio_compra" id="restock_precio_compra" required>
                            </div>
                            <small class="text-muted">Actualiza el costo.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nuevo Precio Venta</label>
                            <div class="input-group">
                                <span class="input-group-text">S/.</span>
                                <input type="number" step="0.01" class="form-control" name="precio_venta" id="restock_precio_venta">
                            </div>
                            <small class="text-muted">Opcional.</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Comprobante (PDF/Imagen)</label>
                        <input type="file" class="form-control" name="comprobante" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar y Actualizar Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showArticleDetails(row) {
    if (event.target.closest('button') || event.target.closest('a')) return;

    const data = JSON.parse(row.getAttribute('data-json'));
    const tbody = document.getElementById('detalleArticuloBody');
    tbody.innerHTML = '';

    for (const [key, value] of Object.entries(data)) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-muted text-end w-50 pe-3">${key}:</td>
            <td class="fw-bold w-50">${value}</td>
        `;
        tbody.appendChild(tr);
    }

    const modal = new bootstrap.Modal(document.getElementById('modalDetalleArticulo'));
    modal.show();
}

function openRestockModal(id, nombre, precioCompra, precioVenta) {
    document.getElementById('restock_cod_articulo').value = id;
    document.getElementById('restock_nombre_articulo').textContent = nombre;
    document.getElementById('restock_precio_compra').value = precioCompra;
    document.getElementById('restock_precio_venta').value = precioVenta;

    const modal = new bootstrap.Modal(document.getElementById('modalReabastecer'));
    modal.show();
}
</script>
