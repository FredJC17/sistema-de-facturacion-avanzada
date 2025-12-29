@extends('layouts.app')

@section('title', 'Editar Artículo')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Artículo</h2>
        <a href="{{ route('articulos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('articulos.update', $articulo) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="descripcion" class="form-label">Descripción *</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{ old('descripcion', $articulo->descripcion) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cod_tipo_articulo" class="form-label">Tipo de Artículo *</label>
                        <select class="form-select" id="cod_tipo_articulo" name="cod_tipo_articulo" required>
                            @foreach($tiposArticulo as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('cod_tipo_articulo', $articulo->cod_tipo_articulo) == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->descripcion_articulo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cod_proveedor" class="form-label">Proveedor *</label>
                        <select class="form-select" id="cod_proveedor" name="cod_proveedor" required>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}" {{ old('cod_proveedor', $articulo->cod_proveedor) == $proveedor->id ? 'selected' : '' }}>
                                    {{ $proveedor->getNombreCompleto() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="precio_costo" class="form-label">Precio Costo *</label>
                        <input type="number" class="form-control" id="precio_costo" name="precio_costo" value="{{ old('precio_costo', $articulo->precio_costo) }}" min="0" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="precio_venta" class="form-label">Precio Venta *</label>
                        <input type="number" class="form-control" id="precio_venta" name="precio_venta" value="{{ old('precio_venta', $articulo->precio_venta) }}" min="0" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="stock" class="form-label">Stock *</label>
                        <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $articulo->stock) }}" min="0" required>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Actualizar Artículo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
