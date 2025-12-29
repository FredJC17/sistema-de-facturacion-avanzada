@extends('layouts.app')
@section('title', 'Nuevo Tipo de Artículo')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-plus-circle me-2" style="color: #166866;"></i>Nuevo Tipo de Artículo</h2>
        <a href="{{ route('tipos-articulo.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Volver</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('tipos-articulo.store') }}">@csrf
                        <div class="mb-4"><label for="descripcion_articulo" class="form-label fw-semibold"><i class="bi bi-tags me-1"></i>Descripción</label><input type="text" class="form-control @error('descripcion_articulo') is-invalid @enderror" id="descripcion_articulo" name="descripcion_articulo" value="{{ old('descripcion_articulo') }}" placeholder="Ej: Electrónica, Alimentos, Ropa" maxlength="50" required>@error('descripcion_articulo')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div class="d-grid gap-2"><button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Guardar</button><a href="{{ route('tipos-articulo.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle me-2"></i>Cancelar</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
