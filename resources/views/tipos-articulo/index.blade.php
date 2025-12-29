@extends('layouts.app')
@section('title', 'Tipos de Artículo')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-tags me-2" style="color: #166866;"></i>Tipos de Artículo</h2>
        <a href="{{ route('tipos-articulo.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Nuevo Tipo</a>
    </div>
    @if(session('success'))<div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
    @if(session('error'))<div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-6"><div class="input-group"><span class="input-group-text"><i class="bi bi-search"></i></span><input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}"></div></div>
                <div class="col-md-3"><select name="estado" class="form-select"><option value="">Todos</option><option value="activo" {{ request('estado') === 'activo' ? 'selected' : '' }}>Activos</option><option value="inactivo" {{ request('estado') === 'inactivo' ? 'selected' : '' }}>Inactivos</option></select></div>
                <div class="col-md-3"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-funnel me-2"></i>Filtrar</button></div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light"><tr><th>Descripción</th><th class="text-center">Estado</th><th class="text-center">Acciones</th></tr></thead>
                    <tbody>
                        @forelse($tiposArticulo as $tipo)
                            <tr>
                                <td><strong>{{ $tipo->descripcion_articulo }}</strong></td>
                                <td class="text-center">{!! \App\Helpers\FormatoHelper::badgeEstado($tipo->estado) !!}</td>
                                <td class="text-center">
                                    <a href="{{ route('tipos-articulo.edit', $tipo) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                    @if($tipo->estaActivo())
                                        <form id="delete-form-{{ $tipo->id }}" method="POST" action="{{ route('tipos-articulo.destroy', $tipo) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="showConfirmModal({
                                                    title: '¿Desactivar tipo?',
                                                    message: 'Se desactivará el tipo {{ $tipo->descripcion_articulo }}.',
                                                    type: 'danger',
                                                    formId: 'delete-form-{{ $tipo->id }}'
                                                })">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form id="activate-form-{{ $tipo->id }}" method="POST" action="{{ route('tipos-articulo.activate', $tipo) }}" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                onclick="showConfirmModal({
                                                    title: '¿Activar tipo?',
                                                    message: 'Se habilitará nuevamente el tipo {{ $tipo->descripcion_articulo }}.',
                                                    type: 'success',
                                                    buttonText: 'Activar',
                                                    formId: 'activate-form-{{ $tipo->id }}'
                                                })">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-4"><i class="bi bi-inbox" style="font-size: 3rem; color: #dee2e6;"></i><p class="text-muted mt-2">No hay tipos de artículo registrados.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $tiposArticulo->links() }}</div>
        </div>
    </div>
</div>
@endsection
