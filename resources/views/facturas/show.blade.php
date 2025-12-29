@extends('layouts.app')

@section('title', 'Detalle de Factura')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-file-earmark-text me-2"></i>Detalle de Factura</h2>
        <div>
            <a href="{{ route('facturas.print', $factura) }}" class="btn btn-primary" target="_blank">
                <i class="bi bi-printer me-2"></i>Imprimir / PDF
            </a>
            <a href="{{ route('facturas.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Información de la factura -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2" style="color: #166866;"></i>Información de la Factura</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-hash me-2"></i>Nro. Factura:</strong><br>
                                <span class="badge bg-primary fs-6">{{ $factura->nro_factura }}</span>
                            </p>
                            <p class="mb-2">
                                <strong><i class="bi bi-calendar-event me-2"></i>Fecha de Emisión:</strong><br>
                                {{ \App\Helpers\FormatoHelper::formatearFecha($factura->fecha_emision) }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-calendar-check me-2"></i>Fecha de Facturación:</strong><br>
                                {{ \App\Helpers\FormatoHelper::formatearFecha($factura->fecha_facturacion) }}
                            </p>
                            <p class="mb-2">
                                <strong><i class="bi bi-circle-fill me-2 {{ $factura->estaActivo() ? 'text-success' : 'text-secondary' }}"></i>Estado:</strong><br>
                                {!! \App\Helpers\FormatoHelper::badgeEstado($factura->estado) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del cliente -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-person me-2" style="color: #166866;"></i>Información del Cliente</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-person-fill me-2"></i>Nombre:</strong><br>
                                {{ $factura->cliente->getNombreCompleto() }}
                            </p>
                            <p class="mb-2">
                                <strong><i class="bi bi-card-text me-2"></i>Documento:</strong><br>
                                {{ $factura->cliente->tipoDocumento->descripcion_tipo_doc }}: {{ $factura->cliente->documento }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-geo-alt me-2"></i>Ciudad:</strong><br>
                                {{ $factura->cliente->ciudad->descripcion_ciudad ?? 'N/A' }}
                            </p>
                            <p class="mb-2">
                                <strong><i class="bi bi-telephone me-2"></i>Teléfono:</strong><br>
                                {{ $factura->cliente->telefono ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalles de productos -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2" style="color: #166866;"></i>Productos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio Unit.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($factura->detalles as $detalle)
                                <tr>
                                    <td>
                                        <strong>{{ $detalle->articulo->descripcion }}</strong><br>
                                        <small class="text-muted">{{ $detalle->articulo->tipoArticulo->descripcion_articulo }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $detalle->cantidad }}</span>
                                    </td>
                                    <td class="text-end">
                                        {{ \App\Helpers\FormatoHelper::formatearMoneda($detalle->articulo->precio_venta) }}
                                    </td>
                                    <td class="text-end fw-bold">
                                        {{ \App\Helpers\FormatoHelper::formatearMoneda($detalle->total) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen de totales -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-calculator me-2" style="color: #166866;"></i>Resumen</h5>
                </div>
                <div class="card-body">
                    <!-- Subtotal -->
                    <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                        <span class="text-muted">Subtotal:</span>
                        <strong class="fs-5">{{ \App\Helpers\FormatoHelper::formatearMoneda($factura->subtotal) }}</strong>
                    </div>

                    <!-- IGV -->
                    <div class="d-flex justify-content-between mb-3 pb-2 border-bottom">
                        <span class="text-muted">
                            <i class="bi bi-receipt me-1"></i>IGV (18%):
                        </span>
                        <strong class="fs-5">{{ \App\Helpers\FormatoHelper::formatearMoneda($factura->igv) }}</strong>
                    </div>

                    <!-- Total -->
                    <div class="d-flex justify-content-between align-items-center p-3 rounded" style="background-color: rgba(22, 104, 102, 0.1);">
                        <h4 class="mb-0" style="color: #166866;">
                            <i class="bi bi-cash-coin me-2"></i>Total:
                        </h4>
                        <h3 class="mb-0 fw-bold" style="color: #166866;">
                            {{ \App\Helpers\FormatoHelper::formatearMoneda($factura->total_factura) }}
                        </h3>
                    </div>

                    <!-- Información adicional -->
                    <div class="mt-4 pt-3 border-top">
                        <p class="small text-muted mb-2">
                            <i class="bi bi-info-circle me-1"></i>
                            Total de productos: <strong>{{ $factura->detalles->count() }}</strong>
                        </p>
                        <p class="small text-muted mb-0">
                            <i class="bi bi-box-seam me-1"></i>
                            Total de unidades: <strong>{{ $factura->detalles->sum('cantidad') }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    .sticky-top {
        z-index: 1000;
    }
</style>
@endpush
