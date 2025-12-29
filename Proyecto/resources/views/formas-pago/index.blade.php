@extends('layouts.app')
@section('title', 'Formas de Pago')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-credit-card me-2" style="color: #166866;"></i>Formas de Pago</h2>
        <a href="{{ route('formas-pago.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Nueva Forma</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
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
                        @forelse($formasPago as $forma)
                            <tr>
                                <td><strong>{{ $forma->descripcion_pago }}</strong></td>
                                <td class="text-center">{!! \App\Helpers\FormatoHelper::badgeEstado($forma->estado) !!}</td>
                                <td class="text-center">
                                    <a href="{{ route('formas-pago.edit', $forma) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-pencil"></i></a>
                                    @if($forma->estaActivo())
                                        <form id="delete-form-{{ $forma->id }}" method="POST" action="{{ route('formas-pago.destroy', $forma) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="showConfirmModal({
                                                    title: '¿Desactivar forma de pago?',
                                                    message: 'Se desactivará la forma de pago {{ $forma->descripcion_pago }}.',
                                                    type: 'danger',
                                                    formId: 'delete-form-{{ $forma->id }}'
                                                })">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form id="activate-form-{{ $forma->id }}" method="POST" action="{{ route('formas-pago.activate', $forma) }}" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                onclick="showConfirmModal({
                                                    title: '¿Activar forma de pago?',
                                                    message: 'Se habilitará nuevamente la forma de pago {{ $forma->descripcion_pago }}.',
                                                    type: 'success',
                                                    buttonText: 'Activar',
                                                    formId: 'activate-form-{{ $forma->id }}'
                                                })">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-4"><i class="bi bi-inbox" style="font-size: 3rem; color: #dee2e6;"></i><p class="text-muted mt-2">No hay formas de pago registradas.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $formasPago->links() }}</div>
        </div>
    </div>
</div>
@endsection
