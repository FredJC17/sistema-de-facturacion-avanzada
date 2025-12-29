@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Clientes</h2>
        <div>
            <button type="button" class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#modalReporte">
                <i class="bi bi-file-earmark-pdf"></i> Reportes
            </button>
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Cliente
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
            <form method="GET" action="{{ route('clientes.index') }}" class="row g-3">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="search" placeholder="Buscar por nombre, apellido, documento o email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="sort_by" onchange="this.form.submit()">
                        <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Orden: Reciente</option>
                        <option value="nombre" {{ request('sort_by') == 'nombre' ? 'selected' : '' }}>Nombre (A-Z)</option>
                        <option value="compras_monto" {{ request('sort_by') == 'compras_monto' ? 'selected' : '' }}>Mayor Gasto</option>
                        <option value="actividad" {{ request('sort_by') == 'actividad' ? 'selected' : '' }}>Más Activos</option>
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
                            <th>Email</th>
                            <th>Ciudad</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientes as $cliente)
                            <tr onclick="showClientDetails(this)" 
                                data-json="{{ json_encode([
                                    'Nombre' => $cliente->getNombreCompleto(),
                                    'Documento' => $cliente->documento,
                                    'Email' => $cliente->email,
                                    'Teléfono' => $cliente->telefono ?? 'N/A',
                                    'Ciudad' => $cliente->ciudad->nombre,
                                    'Dirección' => $cliente->direccion ?? 'N/A',
                                    'Rol' => ucfirst($cliente->rol),
                                    'Estado' => ucfirst($cliente->estado)
                                ]) }}"
                                style="cursor: pointer;">
                                <td>{{ $cliente->documento }}</td>
                                <td>{{ $cliente->getNombreCompleto() }}</td>
                                <td>{{ $cliente->email }}</td>
                                <td>{{ $cliente->ciudad->nombre }}</td>
                                <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $cliente->rol == 'administrator' ? 'bg-danger' : 'bg-primary' }}">
                                        {{ ucfirst($cliente->rol) }}
                                    </span>
                                </td>
                                <td class="text-center">{!! \App\Helpers\FormatoHelper::badgeEstado($cliente->estado) !!}</td>
                                <td>
                                    <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($cliente->estaActivo())
                                        <form id="delete-form-{{ $cliente->id }}" action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="showConfirmModal({
                                                    title: '¿Desactivar cliente?',
                                                    message: 'Se desactivará al cliente {{ $cliente->nombre }} {{ $cliente->apellido }}.',
                                                    type: 'danger',
                                                    formId: 'delete-form-{{ $cliente->id }}'
                                                })">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form id="activate-form-{{ $cliente->id }}" action="{{ route('clientes.activate', $cliente) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="showConfirmModal({
                                                    title: '¿Activar cliente?',
                                                    message: 'Se habilitará nuevamente al cliente {{ $cliente->nombre }} {{ $cliente->apellido }}.',
                                                    type: 'success',
                                                    buttonText: 'Activar',
                                                    formId: 'activate-form-{{ $cliente->id }}'
                                                })">
                                                <i class="bi bi-arrow-clockwise"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No se encontraron clientes.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal de Reportes -->
<div class="modal fade" id="modalReporte" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generar Reporte de Clientes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('clientes.reporte') }}" method="POST" target="_blank">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Reporte</label>
                        <select class="form-select" name="tipo_reporte" required>
                            <option value="compras_monto">🌟 Top Clientes (Mayor Gasto)</option>
                            <option value="compras_cantidad">📦 Más Productos Comprados</option>
                            <option value="actividad_frecuencia">🔄 Más Activos (Frecuencia)</option>
                            <option value="inactivos">💤 Clientes Inactivos</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Periodo de Tiempo</label>
                        <select class="form-select" name="periodo" id="periodoSelect" required>
                            <option value="dia">Día Específico</option>
                            <option value="semana">Semana</option>
                            <option value="mes" selected>Mes</option>
                            <option value="anio">Año</option>
                            <option value="personalizado">Rango Personalizado</option>
                        </select>
                    </div>

                    <!-- Input Día -->
                    <div class="mb-3 d-none input-periodo" id="inputDia">
                        <label class="form-label">Seleccionar Fecha</label>
                        <input type="date" class="form-control" name="fecha_dia" value="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Input Semana -->
                    <div class="mb-3 d-none input-periodo" id="inputSemana">
                        <label class="form-label">Seleccionar Semana</label>
                        <input type="week" class="form-control" name="fecha_semana">
                        <small class="text-muted">Se generará el reporte de lunes a domingo de la semana seleccionada.</small>
                    </div>

                    <!-- Input Mes -->
                    <div class="mb-3 input-periodo" id="inputMes">
                        <label class="form-label">Seleccionar Mes</label>
                        <input type="month" class="form-control" name="fecha_mes" value="{{ date('Y-m') }}">
                    </div>

                    <!-- Input Año -->
                    <div class="mb-3 d-none input-periodo" id="inputAnio">
                        <label class="form-label">Seleccionar Año</label>
                        <select class="form-select" name="fecha_anio">
                            @for($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- Input Personalizado -->
                    <div class="row d-none input-periodo" id="inputPersonalizado">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Desde</label>
                            <input type="date" class="form-control" name="fecha_inicio">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hasta</label>
                            <input type="date" class="form-control" name="fecha_fin">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mostrar</label>
                        <select class="form-select" name="limite" required>
                            <option value="5">Top 5</option>
                            <option value="10" selected>Top 10</option>
                            <option value="20">Top 20</option>
                            <option value="todos">Todos</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-file-earmark-pdf"></i> Generar PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- Modal Detalles Cliente -->
<div class="modal fade" id="modalDetalleCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-person-lines-fill me-2"></i>Detalles del Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tbody id="detalleClienteBody">
                        <!-- JS populated -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showClientDetails(row) {
    // Evitar que el click en botones dispare el row click
    if (event.target.closest('button') || event.target.closest('a')) return;

    const data = JSON.parse(row.getAttribute('data-json'));
    const tbody = document.getElementById('detalleClienteBody');
    tbody.innerHTML = '';

    for (const [key, value] of Object.entries(data)) {
        let icon = 'bi-dot';
        if(key === 'Email') icon = 'bi-envelope';
        if(key === 'Teléfono') icon = 'bi-phone';
        if(key === 'Ciudad') icon = 'bi-geo-alt';
        
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="text-muted text-end w-50 pe-3"><i class="bi ${icon} me-1"></i>${key}:</td>
            <td class="fw-bold w-50">${value}</td>
        `;
        tbody.appendChild(tr);
    }

    const modal = new bootstrap.Modal(document.getElementById('modalDetalleCliente'));
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // ... existing JS ...
    const periodoSelect = document.getElementById('periodoSelect');
    const inputs = {
        'dia': document.getElementById('inputDia'),
        'semana': document.getElementById('inputSemana'),
        'mes': document.getElementById('inputMes'),
        'anio': document.getElementById('inputAnio'),
        'personalizado': document.getElementById('inputPersonalizado')
    };

    function updateInputs() {
        const selected = periodoSelect.value;
        
        // Ocultar todos
        Object.values(inputs).forEach(el => {
            if(el) {
                el.classList.add('d-none');
                // Deshabilitar inputs ocultos para evitar envío de datos basura (opcional, pero buena práctica)
                const innerInputs = el.querySelectorAll('input, select');
                innerInputs.forEach(i => i.disabled = true);
            }
        });

        // Mostrar seleccionado
        const current = inputs[selected];
        if(current) {
            current.classList.remove('d-none');
            const innerInputs = current.querySelectorAll('input, select');
            innerInputs.forEach(i => i.disabled = false);
        }
    }

    periodoSelect.addEventListener('change', updateInputs);
    
    // Ejecutar al inicio para establecer estado inicial
    updateInputs();
});
</script>
@endpush
