@extends('layouts.app')

@section('title', 'Dashboard - SFA')

@section('content')
<div class="container-fluid">
    <!-- Header con logo -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/logo/sfa.png') }}" alt="SFA Logo" height="50" class="me-3">
                <div>
                    <h2 class="mb-0">Dashboard</h2>
                    <p class="text-muted mb-0">Bienvenido, {{ auth()->user()->getNombreCompleto() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-md-end">
            <small class="text-muted">
                <i class="bi bi-calendar3 me-1"></i>
                {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
            </small>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Contenido Condicional por Rol -->
    @if(auth()->user()->isAdministrator())
        <!-- DASHBOARD ADMINISTRADOR -->
        
        <!-- Tarjetas de estadísticas -->
        <div class="row mb-4">
            <!-- Total Clientes -->
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card stat-card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2 text-uppercase small">
                                    <i class="bi bi-people me-1"></i>Clientes
                                </h6>
                                <h2 class="mb-0 fw-bold" style="color: #166866;">
                                    {{ number_format($stats['total_clientes']) }}
                                </h2>
                                <small class="text-success">
                                    <i class="bi bi-arrow-up"></i> Registrados
                                </small>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px; background-color: rgba(22, 104, 102, 0.1);">
                                <i class="bi bi-people" style="font-size: 2rem; color: #166866;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Artículos -->
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card stat-card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2 text-uppercase small">
                                    <i class="bi bi-box-seam me-1"></i>Artículos
                                </h6>
                                <h2 class="mb-0 fw-bold" style="color: #198754;">
                                    {{ number_format($stats['total_articulos']) }}
                                </h2>
                                <small class="text-muted">
                                    <i class="bi bi-tag"></i> Total
                                </small>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px; background-color: rgba(25, 135, 84, 0.1);">
                                <i class="bi bi-box-seam" style="font-size: 2rem; color: #198754;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Facturas -->
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card stat-card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2 text-uppercase small">
                                    <i class="bi bi-receipt-cutoff me-1"></i>Facturas
                                </h6>
                                <h2 class="mb-0 fw-bold" style="color: #fd7e14;">
                                    {{ number_format($stats['total_facturas']) }}
                                </h2>
                                <small class="text-muted">
                                    <i class="bi bi-calendar-check"></i> Emitidas
                                </small>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px; background-color: rgba(253, 126, 20, 0.1);">
                                <i class="bi bi-receipt-cutoff" style="font-size: 2rem; color: #fd7e14;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Bajo -->
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card stat-card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2 text-uppercase small">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Stock Bajo
                                </h6>
                                <h2 class="mb-0 fw-bold" style="color: #dc3545;">
                                    {{ number_format($stats['articulos_bajo_stock']) }}
                                </h2>
                                <small class="text-danger">
                                    <i class="bi bi-arrow-down"></i> Crítico
                                </small>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 60px; height: 60px; background-color: rgba(220, 53, 69, 0.1);">
                                <i class="bi bi-exclamation-triangle" style="font-size: 2rem; color: #dc3545;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accesos rápidos -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-lightning-charge me-2" style="color: #166866;"></i>
                            Accesos Rápidos
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="{{ route('facturas.create') }}" class="btn btn-outline-primary w-100 py-3">
                                    <i class="bi bi-plus-circle fs-4 d-block mb-2"></i>
                                    Nueva Factura
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('clientes.create') }}" class="btn btn-outline-success w-100 py-3">
                                    <i class="bi bi-person-plus fs-4 d-block mb-2"></i>
                                    Nuevo Cliente
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('articulos.create') }}" class="btn btn-outline-info w-100 py-3">
                                    <i class="bi bi-box-seam fs-4 d-block mb-2"></i>
                                    Nuevo Artículo
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('facturas.index') }}" class="btn btn-outline-warning w-100 py-3">
                                    <i class="bi bi-file-earmark-text fs-4 d-block mb-2"></i>
                                    Ver Reportes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenido principal Admin -->
        <div class="row">
            <!-- Facturas Recientes -->
            <div class="col-lg-8 mb-4">
                <div class="card border-0">
                    <div class="card-header card-header-custom border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-clock-history me-2" style="color: #166866;"></i>
                                Últimas Facturas Emitidas
                            </h5>
                            <a href="{{ route('facturas.index') }}" class="btn btn-sm btn-outline-primary">
                                Ver todas <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($recent_facturas->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light-custom">
                                        <tr>
                                            <th>Nro. Factura</th>
                                            <th>Cliente</th>
                                            <th>Fecha</th>
                                            <th class="text-end">Total</th>
                                            <th class="text-center">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recent_facturas as $factura)
                                            <tr>
                                                <td><span class="badge bg-primary">{{ $factura->nro_factura }}</span></td>
                                                <td>{{ $factura->cliente->getNombreCompleto() }}</td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ \App\Helpers\FormatoHelper::formatearFecha($factura->fecha_facturacion) }}
                                                    </small>
                                                </td>
                                                <td class="text-end fw-bold" style="color: #166866;">
                                                    {{ \App\Helpers\FormatoHelper::formatearMoneda($factura->total_factura) }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('facturas.show', $factura) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #dee2e6;"></i>
                                <p class="text-muted mt-3 mb-0">No hay facturas registradas.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Artículos con Stock Bajo -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0">
                    <div class="card-header card-header-custom border-bottom">
                        <h5 class="mb-0">
                            <i class="bi bi-exclamation-triangle me-2 text-danger"></i>
                            Stock Bajo
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($articulos_bajo_stock->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($articulos_bajo_stock as $articulo)
                                    <div class="list-group-item px-0 py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $articulo->descripcion }}</h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-tag me-1"></i>
                                                    {{ $articulo->tipoArticulo->descripcion_articulo }}
                                                </small>
                                            </div>
                                            <span class="badge bg-danger ms-2">
                                                <i class="bi bi-box me-1"></i>{{ $articulo->stock }}
                                            </span>
                                        </div>
                                        @php
                                            $widthVal = $articulo->stock < 10 ? ($articulo->stock * 10) : 100;
                                            $styleAttr = 'style="width: ' . $widthVal . '%"';
                                        @endphp
                                        <div class="progress mt-2" style="height: 5px;">
                                            <div class="progress-bar bg-danger" {!! $styleAttr !!}>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-check-circle" style="font-size: 3rem; color: #198754;"></i>
                                <p class="text-muted mt-3 mb-0">Todos los artículos tienen stock suficiente.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @else
        <!-- DASHBOARD CLIENTE -->
        <div class="row">
            <!-- Resumen Cliente -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <div class="rounded-circle bg-custom-secondary d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="bi bi-person text-secondary" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h4 class="card-title">{{ auth()->user()->getNombreCompleto() }}</h4>
                        <p class="text-muted mb-4">{{ auth()->user()->email }}</p>
                        
                        <div class="row g-3 mt-4">
                            <div class="col-6">
                                <div class="p-3 border rounded bg-custom-secondary">
                                    <h3 class="mb-0 fw-bold text-primary">{{ $stats['mis_facturas'] }}</h3>
                                    <small class="text-muted">Compras</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 border rounded bg-custom-secondary">
                                    <h5 class="mb-0 fw-bold text-success">{{ \App\Helpers\FormatoHelper::formatearMoneda($stats['total_gastado']) }}</h5>
                                    <small class="text-muted">Gastado</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historial de Compras -->
            <div class="col-md-8 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header card-header-custom py-3">
                        <h5 class="mb-0">
                            <i class="bi bi-bag-check me-2" style="color: #166866;"></i>
                            Mis Últimas Compras
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($recent_facturas) && $recent_facturas->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light-custom">
                                        <tr>
                                            <th>Nro. Factura</th>
                                            <th>Fecha</th>
                                            <th class="text-end">Monto</th>
                                            <th class="text-center">Detalles</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recent_facturas as $factura)
                                            <tr>
                                                <td><span class="badge bg-secondary">{{ $factura->nro_factura }}</span></td>
                                                <td>{{ \App\Helpers\FormatoHelper::formatearFecha($factura->fecha_facturacion) }}</td>
                                                <td class="text-end fw-bold">{{ \App\Helpers\FormatoHelper::formatearMoneda($factura->total_factura) }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('facturas.show', $factura) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-file-text"></i> Ver Factura
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-cart-x" style="font-size: 4rem; color: #dee2e6;"></i>
                                <h5 class="mt-3">Aún no tienes compras registradas</h5>
                                <p class="text-muted">Tus facturas aparecerán aquí una vez que realices una compra.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


@endsection

@push('styles')
<style>
    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-left: 4px solid;
    }

    .stat-card:nth-child(1) {
        border-left-color: #166866;
    }

    .stat-card:nth-child(2) {
        border-left-color: #198754;
    }

    .stat-card:nth-child(3) {
        border-left-color: #fd7e14;
    }

    .stat-card:nth-child(4) {
        border-left-color: #dc3545;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .btn-outline-primary {
        color: #166866;
        border-color: #166866;
    }

    .btn-outline-primary:hover {
        background-color: #166866;
        border-color: #166866;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>
@endpush
