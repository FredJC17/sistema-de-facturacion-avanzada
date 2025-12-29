@extends('layouts.app')

@section('title', 'Reportes y Estadísticas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-graph-up-arrow me-2" style="color: #166866;"></i>Reportes y Estadísticas</h2>
    </div>

    <!-- Sección Ventas -->
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0">Evolución de Ventas</h5>
                        <select class="form-select form-select-sm" style="width: auto;" id="ventasPeriodo" onchange="updateVentasChart()">
                            <option value="7">Últimos 7 días</option>
                            <option value="30">Último mes</option>
                            <option value="90">Últimos 3 meses</option>
                            <option value="180" selected>Últimos 6 meses</option>
                            <option value="365">Último año</option>
                        </select>
                    </div>
                    <div style="position: relative; height: 300px;">
                        <canvas id="chartVentas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm border-start border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 bg-info bg-opacity-10 text-info me-3">
                            <i class="bi bi-cash-coin fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Ventas</h5>
                    </div>
                    <p class="card-text text-muted small">Genera reportes detallados de ingresos por periodo, analizando el desempeño mensual y diario.</p>
                    <button class="btn btn-outline-info w-100 mt-3" data-bs-toggle="modal" data-bs-target="#modalReporteVenta">
                        Generar Reporte Completo
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Artículos -->
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0">Artículos Más Vendidos</h5>
                        <select class="form-select form-select-sm" style="width: auto;" id="articulosTop" onchange="updateArticulosChart()">
                            <option value="3">Top 3</option>
                            <option value="5" selected>Top 5</option>
                            <option value="10">Top 10</option>
                        </select>
                    </div>
                    <div style="position: relative; height: 300px;">
                        <canvas id="chartArticulos"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 bg-warning bg-opacity-10 text-warning me-3">
                            <i class="bi bi-box-seam fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Artículos</h5>
                    </div>
                    <p class="card-text text-muted small">Analiza rotación de inventario, stock bajo y valoración de mercancía.</p>
                    <button class="btn btn-outline-warning w-100 mt-3" data-bs-toggle="modal" data-bs-target="#modalReporteArticulo">
                        Generar Reporte de Stock
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Clientes -->
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0">Mejores Clientes</h5>
                        <select class="form-select form-select-sm" style="width: auto;" id="clientesTop" onchange="updateClientesChart()">
                            <option value="3">Top 3</option>
                            <option value="5" selected>Top 5</option>
                            <option value="10">Top 10</option>
                        </select>
                    </div>
                    <div style="position: relative; height: 300px;">
                        <canvas id="chartClientes"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 bg-primary bg-opacity-10 text-primary me-3">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Clientes</h5>
                    </div>
                    <p class="card-text text-muted small">Identifica a tus clientes VIP y analiza patrones de compra.</p>
                    <button class="btn btn-outline-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#modalReporteCliente">
                        Generar Reporte Clientes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Proveedores -->
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0">Proveedores con Mayor Catálogo</h5>
                        <select class="form-select form-select-sm" style="width: auto;" id="proveedoresTop" onchange="updateProveedoresChart()">
                            <option value="3">Top 3</option>
                            <option value="5" selected>Top 5</option>
                            <option value="10">Top 10</option>
                        </select>
                    </div>
                    <div style="position: relative; height: 300px;">
                        <canvas id="chartProveedores"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 bg-success bg-opacity-10 text-success me-3">
                            <i class="bi bi-truck fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Proveedores</h5>
                    </div>
                    <p class="card-text text-muted small">Distribución de productos por proveedor y análisis de abastecimiento.</p>
                    <button class="btn btn-outline-success w-100 mt-3" data-bs-toggle="modal" data-bs-target="#modalReporteProveedor">
                        Generar Reporte Proveedores
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Rentabilidad -->
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-muted mb-0">Análisis de Rentabilidad</h5>
                        <div class="d-flex gap-2">
                             <select class="form-select form-select-sm" style="width: auto;" id="rentabilidadPeriodo" onchange="updateRentabilidadPeriodo()">
                                <option value="7">Últimos 7 días</option>
                                <option value="30" selected>Últimos 30 días</option>
                                <option value="cur_month">Este mes</option>
                                <option value="custom">Personalizado</option>
                             </select>
                             <div id="customDateInputs" class="d-flex gap-2 d-none">
                                <input type="date" class="form-control form-control-sm" 
                                       id="rentabilidadFechaInicio" 
                                       style="width: auto;" 
                                       title="Fecha inicio">
                                <input type="date" class="form-control form-control-sm" 
                                       id="rentabilidadFechaFin" 
                                       style="width: auto;" 
                                       title="Fecha fin">
                                <button class="btn btn-sm btn-danger" onclick="updateRentabilidadChart()">
                                    <i class="bi bi-search"></i>
                                </button>
                             </div>
                         </div>
                    </div>
                    <div style="position: relative; height: 300px;">
                        <canvas id="chartRentabilidad"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm border-start border-4 border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle p-3 bg-danger bg-opacity-10 text-danger me-3">
                            <i class="bi bi-graph-up fs-4"></i>
                        </div>
                        <h5 class="card-title mb-0">Rentabilidad</h5>
                    </div>
                    <p class="card-text text-muted small">Analiza ingresos vs gastos, márgenes de ganancia y proyecciones financieras.</p>
                    <button class="btn btn-outline-danger w-100 mt-3" data-bs-toggle="modal" data-bs-target="#modalReporteRentabilidad">
                        Generar Reporte de Rentabilidad
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modales -->
@include('reportes.modales.cliente')
@include('reportes.modales.proveedor')
@include('reportes.modales.articulo')
@include('reportes.modales.venta')
@include('reportes.modales.rentabilidad')
@include('reportes.modales.configurar_rentabilidad')

@endsection

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Chart instances (global for updates)
    let chartVentasInstance = null;
    let chartArticulosInstance = null;
    let chartClientesInstance = null;
    let chartProveedoresInstance = null;
    let chartRentabilidadInstance = null;

document.addEventListener('DOMContentLoaded', function() {
    // Data passed from Controller
    const chartVentasData = JSON.parse('{!! addslashes(json_encode($chartVentas)) !!}');
    const chartArticulosData = JSON.parse('{!! addslashes(json_encode($chartArticulos)) !!}');
    const chartClientesData = JSON.parse('{!! addslashes(json_encode($chartClientes)) !!}');
    const chartProveedoresData = JSON.parse('{!! addslashes(json_encode($chartProveedores)) !!}');
    const chartRentabilidadData = JSON.parse('{!! addslashes(json_encode($chartRentabilidad)) !!}');

    // Instances defined globally above

    // ---------------- VENTAS CHART (Line) ----------------
    const ctxVentas = document.getElementById('chartVentas').getContext('2d');
    chartVentasInstance = new Chart(ctxVentas, {
        type: 'line',
        data: {
            labels: chartVentasData.labels,
            datasets: [{
                label: 'Ventas (S/.)',
                data: chartVentasData.data,
                borderColor: '#0dcaf0',
                backgroundColor: 'rgba(13, 202, 240, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'top' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // ---------------- ARTÍCULOS CHART (Bar) ----------------
    const ctxArticulos = document.getElementById('chartArticulos').getContext('2d');
    chartArticulosInstance = new Chart(ctxArticulos, {
        type: 'bar',
        data: {
            labels: chartArticulosData.labels,
            datasets: [{
                label: 'Cantidad Vendida',
                data: chartArticulosData.data,
                backgroundColor: '#ffc107'
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // ---------------- CLIENTES CHART (Horizontal Bar) ----------------
    const ctxClientes = document.getElementById('chartClientes').getContext('2d');
    chartClientesInstance = new Chart(ctxClientes, {
        type: 'bar',
        data: {
            labels: chartClientesData.labels,
            datasets: [{
                label: 'Total Comprado (S/.)',
                data: chartClientesData.data,
                backgroundColor: '#0d6efd'
            }]
        },
        options: { 
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { beginAtZero: true }
            }
        }
    });

    // ---------------- PROVEEDORES CHART (Doughnut) ----------------
    const ctxProveedores = document.getElementById('chartProveedores').getContext('2d');
    chartProveedoresInstance = new Chart(ctxProveedores, {
        type: 'doughnut',
        data: {
            labels: chartProveedoresData.labels,
            datasets: [{
                label: 'Gasto Total (S/.)',
                data: chartProveedoresData.data,
                backgroundColor: [
                    '#198754', '#20c997', '#0dcaf0', '#ffc107', '#dc3545'
                ]
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right' }
            }
        }
    });

    // ---------------- RENTABILIDAD CHART (Bar - Dual Dataset) ----------------
    // chartRentabilidadInstance defined globally
    const ctxRentabilidad = document.getElementById('chartRentabilidad').getContext('2d');
    chartRentabilidadInstance = new Chart(ctxRentabilidad, {
        type: 'bar',
        data: {
            labels: chartRentabilidadData.labels,
            datasets: [
                {
                    label: 'Ingresos (S/.)',
                    data: chartRentabilidadData.ingresos,
                    backgroundColor: '#198754',
                    borderColor: '#157347',
                    borderWidth: 1
                },
                {
                    label: 'Gastos (S/.)',
                    data: chartRentabilidadData.gastos,
                    backgroundColor: '#dc3545',
                    borderColor: '#bb2d3b',
                    borderWidth: 1
                }
            ]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'top' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
    
    // Set default dates for inputs (hidden but needed if switched to custom)
    const today = new Date();
    const thirtyDaysAgo = new Date();
    thirtyDaysAgo.setDate(today.getDate() - 30);
    
    document.getElementById('rentabilidadFechaFin').valueAsDate = today;
    document.getElementById('rentabilidadFechaInicio').valueAsDate = thirtyDaysAgo;
    
    // Initialize with default view calculation? Or relies on backend initial load (which is 6 months)
    // The initial backend load is 6 months (Monthly).
    // Let's trigger a load for the default selected "Last 30 Days" so it matches the dropdown
    updateRentabilidadPeriodo();

    // --- Logic for Modals (Existing) ---
    const periodoSelects = document.querySelectorAll('.periodo-select');
    periodoSelects.forEach(select => {
        select.addEventListener('change', function() {
            const modal = this.closest('.modal');
            const sorted = this.value;
            modal.querySelectorAll('.input-periodo').forEach(el => {
                el.classList.add('d-none');
                el.querySelectorAll('input, select').forEach(i => i.disabled = true);
            });
            const activeInput = modal.querySelector(`.input-${sorted}`);
            if(activeInput) {
                activeInput.classList.remove('d-none');
                activeInput.querySelectorAll('input, select').forEach(i => i.disabled = false);
            }
        });
        select.dispatchEvent(new Event('change'));
    });
});

// Update functions for filters (to be implemented with backend endpoints)
function updateVentasChart() {
    const periodo = document.getElementById('ventasPeriodo').value;
    console.log('Actualizar chart de ventas con período:', periodo);
}

function updateArticulosChart() {
    const top = document.getElementById('articulosTop').value;
    console.log('Actualizar chart de artículos con top:', top);
}

function updateClientesChart() {
    const top = document.getElementById('clientesTop').value;
    console.log('Actualizar chart de clientes con top:', top);
}

function updateProveedoresChart() {
    const top = document.getElementById('proveedoresTop').value;
    console.log('Actualizar chart de proveedores con top:', top);
}

function updateRentabilidadPeriodo() {
    const periodo = document.getElementById('rentabilidadPeriodo').value;
    const customInputs = document.getElementById('customDateInputs');
    
    if (periodo === 'custom') {
        customInputs.classList.remove('d-none');
        // Do not auto-update, wait for button click
    } else {
        customInputs.classList.add('d-none');
        
        let fechaInicio = new Date();
        let fechaFin = new Date();
        
        if (periodo === '7') {
            fechaInicio.setDate(fechaFin.getDate() - 7);
        } else if (periodo === '30') {
            fechaInicio.setDate(fechaFin.getDate() - 30);
        } else if (periodo === 'cur_month') {
            fechaInicio = new Date(fechaFin.getFullYear(), fechaFin.getMonth(), 1);
        }
        
        // Format dates YYYY-MM-DD
        const startStr = fechaInicio.toISOString().split('T')[0];
        const endStr = fechaFin.toISOString().split('T')[0];
        
        document.getElementById('rentabilidadFechaInicio').value = startStr;
        document.getElementById('rentabilidadFechaFin').value = endStr;
        
        // Auto update
        updateRentabilidadChart();
    }
}

function updateRentabilidadChart() {
    const fechaInicio = document.getElementById('rentabilidadFechaInicio').value;
    const fechaFin = document.getElementById('rentabilidadFechaFin').value;
    
    if (!fechaInicio || !fechaFin) {
        alert('Selecciona ambas fechas para filtrar');
        return;
    }

    updateRentabilidadChartWithArticles(fechaInicio, fechaFin, []);
}

function updateRentabilidadChartWithArticles(fechaInicio, fechaFin, articulos = []) {
    if (!fechaInicio || !fechaFin) {
        alert('Selecciona ambas fechas para filtrar');
        return;
    }

    // Mostrar loading
    const chartContainer = document.getElementById('chartRentabilidad').parentElement;
    chartContainer.style.opacity = '0.5';

    const articulosParam = articulos.length > 0 ? `&articulos=${articulos.join(',')}` : '';
    const url = `{{ route('reportes.rentabilidad-data') }}?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}${articulosParam}`;

    fetch(url)
        .then(res => {
            if (!res.ok) {
                // If response is not OK (e.g. 500, 404), throw error with status
                return res.text().then(text => { throw new Error(`HTTP ${res.status} ${res.statusText}: ${text.substring(0, 100)}`) });
            }
            return res.json();
        })
        .then(data => {
            if (data.error) {
                console.error('Server error:', data.error);
                alert('Error del servidor: ' + data.error);
                chartContainer.style.opacity = '1';
                return;
            }
            chartRentabilidadInstance.data.labels = data.labels;
            chartRentabilidadInstance.data.datasets[0].data = data.ingresos;
            chartRentabilidadInstance.data.datasets[1].data = data.gastos;
            chartRentabilidadInstance.update();
            
            // Remover loading
            chartContainer.style.opacity = '1';
        })
        .catch(error => {
            console.error('Error al actualizar gráfico:', error);
            chartContainer.style.opacity = '1';
            alert('Error al cargar datos. Por favor intenta de nuevo.');
        });
}
</script>
@endpush
