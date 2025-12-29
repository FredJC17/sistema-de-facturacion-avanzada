@extends('layouts.app')

@section('title', 'Facturas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Historial de Facturas (Documentos)</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('facturas.index') }}" class="row g-3">
                <div class="col-md-10">
                    <input type="text" class="form-control" name="search" placeholder="Buscar por número de factura..." value="{{ request('search') }}">
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
                            <th>Nro. Factura</th>
                            <th>Cliente</th>
                            <th>Fecha Emisión</th>
                            <th>Total</th>
                            <th>Documento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($facturas as $factura)
                            <tr>
                                <td><strong>{{ $factura->nro_factura }}</strong></td>
                                <td>{{ $factura->cliente->getNombreCompleto() }}</td>
                                <td>{{ $factura->fecha_emision }}</td>
                                <td><strong>S/. {{ number_format($factura->total_factura, 2) }}</strong></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('facturas.show', $factura) }}" class="btn btn-sm btn-outline-info" title="Ver Detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('facturas.print', $factura) }}" class="btn btn-sm btn-outline-secondary" target="_blank" title="Imprimir">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                        <a href="{{ route('facturas.download', $factura) }}" class="btn btn-sm btn-outline-danger" title="Descargar PDF">
                                            <i class="bi bi-file-earmark-arrow-down"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No se encontraron facturas.</td>
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
@endsection
