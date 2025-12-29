<!-- Inputs Dinámicos de Fecha (Reutilizables) -->
<!-- Input Día -->
<div class="mb-3 d-none input-periodo input-dia">
    <label class="form-label">Seleccionar Fecha</label>
    <input type="date" class="form-control" name="fecha_dia" value="{{ date('Y-m-d') }}">
</div>

<!-- Input Semana -->
<div class="mb-3 d-none input-periodo input-semana">
    <label class="form-label">Seleccionar Semana</label>
    <input type="week" class="form-control" name="fecha_semana">
</div>

<!-- Input Mes -->
<div class="mb-3 input-periodo input-mes">
    <label class="form-label">Seleccionar Mes</label>
    <input type="month" class="form-control" name="fecha_mes" value="{{ date('Y-m') }}">
</div>

<!-- Input Año -->
<div class="mb-3 d-none input-periodo input-anio">
    <label class="form-label">Seleccionar Año</label>
    <select class="form-select" name="fecha_anio">
        @for($i = date('Y'); $i >= 2020; $i--)
            <option value="{{ $i }}">{{ $i }}</option>
        @endfor
    </select>
</div>

<!-- Input Personalizado -->
<div class="row d-none input-periodo input-personalizado">
    <div class="col-md-6 mb-3">
        <label class="form-label">Desde</label>
        <input type="date" class="form-control" name="fecha_inicio">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Hasta</label>
        <input type="date" class="form-control" name="fecha_fin">
    </div>
</div>
