@extends('layouts.app')

@section('title', 'Ciudades - SFA')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-geo-alt me-2" style="color: #166866;"></i>Gestión de Ciudades</h2>
        <a href="{{ route('ciudades.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Nueva Ciudad
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <!-- Filtros -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Buscar por código o nombre..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="activo" {{ request('estado') === 'activo' ? 'selected' : '' }}>Activos</option>
                        <option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel me-2"></i>Filtrar</button>
                </div>
            </form>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ciudades as $ciudad)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $ciudad->codigo_ciudad }}</span></td>
                                <td><strong>{{ $ciudad->nombre }}</strong></td>
                                <td class="text-center">{!! \App\Helpers\FormatoHelper::badgeEstado($ciudad->estado) !!}</td>
                                <td class="text-center">
                                    <a href="{{ route('ciudades.edit', $ciudad) }}" class="btn btn-sm btn-outline-primary me-1">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($ciudad->estaActivo())
                                        <form id="delete-form-{{ $ciudad->id }}" method="POST" action="{{ route('ciudades.destroy', $ciudad) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="showConfirmModal({
                                                    title: '¿Desactivar ciudad?',
                                                    message: 'Se desactivará la ciudad {{ $ciudad->nombre }}.',
                                                    type: 'danger',
                                                    formId: 'delete-form-{{ $ciudad->id }}'
                                                })">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form id="activate-form-{{ $ciudad->id }}" method="POST" action="{{ route('ciudades.activate', $ciudad) }}" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                onclick="showConfirmModal({
                                                    title: '¿Activar ciudad?',
                                                    message: 'Se habilitará nuevamente la ciudad {{ $ciudad->nombre }}.',
                                                    type: 'success',
                                                    buttonText: 'Activar',
                                                    formId: 'activate-form-{{ $ciudad->id }}'
                                                })">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: #dee2e6;"></i>
                                    <p class="text-muted mt-2">No hay ciudades registradas.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-3">
                {{ $ciudades->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
