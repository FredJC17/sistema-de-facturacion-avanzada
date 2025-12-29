@extends('layouts.app')

@section('title', 'Editar Ciudad - SFA')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-pencil me-2" style="color: #166866;"></i>Editar Ciudad</h2>
        <a href="{{ route('ciudades.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('ciudades.update', $ciudad) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="codigo_ciudad" class="form-label fw-semibold">
                                <i class="bi bi-hash me-1"></i>Código
                            </label>
                            <input type="text" class="form-control @error('codigo_ciudad') is-invalid @enderror" 
                                   id="codigo_ciudad" name="codigo_ciudad" value="{{ old('codigo_ciudad', $ciudad->codigo_ciudad) }}" 
                                   placeholder="Ej: LIM, ARQ, CUS" maxlength="10" required>
                            @error('codigo_ciudad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="descripcion_ciudad" class="form-label fw-semibold">
                                <i class="bi bi-geo-alt me-1"></i>Nombre de la Ciudad
                            </label>
                            <input type="text" class="form-control @error('descripcion_ciudad') is-invalid @enderror" 
                                   id="descripcion_ciudad" name="descripcion_ciudad" value="{{ old('descripcion_ciudad', $ciudad->descripcion_ciudad) }}" 
                                   placeholder="Ej: Lima, Arequipa, Cusco" maxlength="100" required>
                            @error('descripcion_ciudad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Actualizar Ciudad
                            </button>
                            <a href="{{ route('ciudades.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
