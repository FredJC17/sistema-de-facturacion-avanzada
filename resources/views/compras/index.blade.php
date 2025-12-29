@extends('layouts.app')

@section('title', 'Gestión de Compras')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-bag-plus me-2" style="color: #166866;"></i>Gestión de Compras</h2>
    </div>

    <!-- Búsqueda y Filtros -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('compras.index') }}" class="row g-3">
                <!-- Búsqueda -->
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Buscar por artículo...">
                    </div>
                </div>
                <!-- Botón Buscar -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
                <!-- Dropdowns de Ordenamiento -->
                <div class="col-md-2">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="fecha_compra_desc" {{ $sortField === 'fecha_compra' && $sortDirection === 'desc' ? 'selected' : '' }}>Orden Reciente</option>
                        <option value="cantidad_desc" {{ $sortField === 'cantidad' && $sortDirection === 'desc' ? 'selected' : '' }}>Mayor Cantidad</option>
                        <option value="precio_compra_desc" {{ $sortField === 'precio_compra' && $sortDirection === 'desc' ? 'selected' : '' }}>Mayor Precio</option>
                        <option value="precio_compra_asc" {{ $sortField === 'precio_compra' && $sortDirection === 'asc' ? 'selected' : '' }}>Menor Precio</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="direction_sort" class="form-select" onchange="this.form.submit()">
                        <option value="desc" {{ $sortDirection === 'desc' ? 'selected' : '' }}>Descendente</option>
                        <option value="asc" {{ $sortDirection === 'asc' ? 'selected' : '' }}>Ascendente</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de Compras -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if($compras->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <a href="{{ route('compras.index', ['sort' => 'id', 'direction' => $sortField === 'id' && $sortDirection === 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}"
                                       class="text-decoration-none text-dark">
                                        ID
                                        @if($sortField === 'id')
                                            <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Artículo</th>
                                <th>Tipo</th>
                                <th class="text-center">
                                    <a href="{{ route('compras.index', ['sort' => 'cantidad', 'direction' => $sortField === 'cantidad' && $sortDirection === 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}"
                                       class="text-decoration-none text-dark">
                                        Cantidad
                                        @if($sortField === 'cantidad')
                                            <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-end">
                                    <a href="{{ route('compras.index', ['sort' => 'precio_compra', 'direction' => $sortField === 'precio_compra' && $sortDirection === 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}"
                                       class="text-decoration-none text-dark">
                                        Precio Compra
                                        @if($sortField === 'precio_compra')
                                            <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-end">Precio Venta</th>
                                <th class="text-end">Total Compra</th>
                                <th>
                                    <a href="{{ route('compras.index', ['sort' => 'fecha_compra', 'direction' => $sortField === 'fecha_compra' && $sortDirection === 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}"
                                       class="text-decoration-none text-dark">
                                        Fecha y Hora
                                        @if($sortField === 'fecha_compra')
                                            <i class="bi bi-arrow-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-center">Comprobante</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($compras as $compra)
                                <tr>
                                    <td><strong>#{{ $compra->id }}</strong></td>
                                    <td>{{ $compra->articulo->descripcion }}</td>
                                    <td><span class="badge bg-info">{{ $compra->articulo->tipoArticulo->descripcion_articulo ?? 'N/A' }}</span></td>
                                    <td class="text-center"><span class="badge bg-secondary">{{ $compra->cantidad }}</span></td>
                                    <td class="text-end">{{ \App\Helpers\FormatoHelper::formatearMoneda($compra->precio_compra) }}</td>
                                    <td class="text-end">{{ \App\Helpers\FormatoHelper::formatearMoneda($compra->precio_venta ?? 0) }}</td>
                                    <td class="text-end"><strong>{{ \App\Helpers\FormatoHelper::formatearMoneda($compra->precio_compra * $compra->cantidad) }}</strong></td>
                                    <td>
                                        <small>
                                            <i class="bi bi-calendar3"></i> {{ \App\Helpers\FormatoHelper::formatearFecha($compra->fecha_compra) }}<br>
                                            <i class="bi bi-clock"></i> {{ $compra->created_at->format('H:i:s') }}
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        @if($compra->comprobante_path)
                                            <span class="badge bg-success"><i class="bi bi-check-circle"></i> Disponible</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="bi bi-x-circle"></i> No disponible</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($compra->comprobante_path)
                                                <a href="{{ route('compras.download', $compra) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   title="Descargar Comprobante">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                                <a href="{{ route('compras.print', $compra) }}" 
                                                   class="btn btn-sm btn-outline-secondary" 
                                                   target="_blank"
                                                   title="Imprimir Comprobante">
                                                    <i class="bi bi-printer"></i>
                                                </a>
                                            @else
                                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                                    <i class="bi bi-file-x"></i> Sin comprobante
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $compras->firstItem() }} a {{ $compras->lastItem() }} de {{ $compras->total() }} registros
                    </div>
                    <div>
                        {{ $compras->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle fs-1 d-block mb-2"></i>
                    <p class="mb-0">No se encontraron compras registradas.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
