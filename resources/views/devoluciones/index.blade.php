@extends('layouts.app')

@section('title', 'Devoluciones')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Devoluciones</h2>
        <a href="{{ route('devoluciones.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Devolución
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
            <form method="GET" action="{{ route('devoluciones.index') }}" class="row g-3">
                <div class="col-md-10">
                    <input type="text" class="form-control" name="search" placeholder="Buscar por número de factura, artículo o motivo..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Factura</th>
                            <th>Artículo</th>
                            <th>Cantidad Devuelta</th>
                            <th>Motivo</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devoluciones as $devolucion)
                            <tr>
                                <td>{{ $devolucion->detalleFactura->factura->nro_factura }}</td>
                                <td>{{ $devolucion->detalleFactura->articulo->descripcion }}</td>
                                <td>{{ $devolucion->cantidad }}</td>
                                <td>{{ $devolucion->motivo }}</td>
                                <td>{{ $devolucion->fecha_devolucion }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No se encontraron devoluciones.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $devoluciones->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
