@extends('layouts.app')

@section('title', 'Proveedores')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Proveedores</h2>
        <a href="{{ route('proveedores.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Proveedor
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('proveedores.index') }}" class="row g-3">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="search" placeholder="Buscar por nombre, documento o ciudad..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="sort_by" onchange="this.form.submit()">
                        <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Más recientes</option>
                        <option value="articulos" {{ request('sort_by') == 'articulos' ? 'selected' : '' }}>Más artículos</option>
                        <option value="nombre" {{ request('sort_by') == 'nombre' ? 'selected' : '' }}>Por nombre</option>
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
                            <th>Documento</th>
                            <th>Nombre Completo</th>
                            <th>Ciudad</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proveedores as $proveedor)
                            <tr onclick="showProviderDetails(this)" 
                                data-json="{{ json_encode([
                                    'Empresa/Nombre' => $proveedor->getNombreCompleto(),
                                    'Documento' => $proveedor->nro_documento,
                                    'Ciudad' => $proveedor->ciudad->nombre,
                                    'Dirección' => $proveedor->direccion ?? 'N/A',
                                    'Teléfono' => $proveedor->telefono ?? 'N/A',
                                    'Estado' => ucfirst($proveedor->estado),
                                    'Artículos Registrados' => $proveedor->articulos_count ?? 'N/A'
                                ]) }}"
                                style="cursor: pointer;">
                                <td>{{ $proveedor->nro_documento }}</td>
                                <td>{{ $proveedor->getNombreCompleto() }}</td>
                                <td>{{ $proveedor->ciudad->nombre }}</td>
                                <td>{{ $proveedor->telefono ?? 'N/A' }}</td>
                                <td class="text-center">{!! \App\Helpers\FormatoHelper::badgeEstado($proveedor->estado) !!}</td>
                                <td>
                                    <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($proveedor->estaActivo())
                                        <form id="delete-form-{{ $proveedor->id }}" action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="showConfirmModal({
                                                    title: '¿Desactivar proveedor?',
                                                    message: 'Se desactivará el proveedor {{ $proveedor->nombre }}.',
                                                    type: 'danger',
                                                    formId: 'delete-form-{{ $proveedor->id }}'
                                                })">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form id="activate-form-{{ $proveedor->id }}" action="{{ route('proveedores.activate', $proveedor) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="showConfirmModal({
                                                    title: '¿Activar proveedor?',
                                                    message: 'Se habilitará nuevamente al proveedor {{ $proveedor->nombre }}.',
                                                    type: 'success',
                                                    buttonText: 'Activar',
                                                    formId: 'activate-form-{{ $proveedor->id }}'
                                                })">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No se encontraron proveedores.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $proveedores->links() }}
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Modal Detalles Proveedor -->
<div class="modal fade" id="modalDetalleProveedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="bi bi-truck me-2"></i>Detalles del Proveedor</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tbody id="detalleProveedorBody"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
function showProviderDetails(row) {
    if (event.target.closest('button') || event.target.closest('a')) return;

    const data = JSON.parse(row.getAttribute('data-json'));
    const tbody = document.getElementById('detalleProveedorBody');
    tbody.innerHTML = '';

    for (const [key, value] of Object.entries(data)) {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-muted text-end w-50 pe-3">${key}:</td>
            <td class="fw-bold w-50">${value}</td>
        `;
        tbody.appendChild(tr);
    }

    const modal = new bootstrap.Modal(document.getElementById('modalDetalleProveedor'));
    modal.show();
}
</script>
@endsection
