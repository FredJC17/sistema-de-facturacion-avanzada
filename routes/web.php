<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\TipoArticuloController;
use App\Http\Controllers\FormaDePagoController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Password Reset Routes
Route::get('/password/reset', [PasswordResetController::class, 'showRequestForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetCode'])->name('password.email');
Route::get('/password/code', [PasswordResetController::class, 'showCodeForm'])->name('password.code.form');
Route::post('/password/verify', [PasswordResetController::class, 'verifyCode'])->name('password.verify');
Route::get('/password/reset-form', [PasswordResetController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/password/update', [PasswordResetController::class, 'resetPassword'])->name('password.update');
Route::post('/password/resend', [PasswordResetController::class, 'resendCode'])->name('password.resend');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rutas de configuración del usuario
    Route::post('/configuracion/cambiar-tema', [ConfiguracionController::class, 'cambiarTema'])->name('configuracion.cambiar-tema');
    Route::get('/configuracion', [ConfiguracionController::class, 'obtener'])->name('configuracion.obtener');
    Route::post('/configuracion', [ConfiguracionController::class, 'guardar'])->name('configuracion.guardar');

    // Administrator only routes
    Route::middleware('App\Http\Middleware\IsAdministrator')->group(function () {
        // Clientes
        Route::resource('clientes', ClienteController::class);
        Route::post('clientes/{cliente}/activate', [ClienteController::class, 'activate'])->name('clientes.activate');
        Route::post('clientes/reporte/generar', [App\Http\Controllers\ReporteClienteController::class, 'generate'])->name('clientes.reporte');

        // Articulos
        Route::resource('articulos', ArticuloController::class);
        Route::post('articulos/{articulo}/update-stock', [ArticuloController::class, 'updateStock'])->name('articulos.update-stock');
        Route::post('articulos/{articulo}/activate', [ArticuloController::class, 'activate'])->name('articulos.activate');

        // Proveedores
        Route::resource('proveedores', ProveedorController::class)->parameters([
            'proveedores' => 'proveedor'
        ]);
        Route::post('proveedores/{proveedor}/activate', [ProveedorController::class, 'activate'])->name('proveedores.activate');
        Route::post('proveedores/reporte/generar', [App\Http\Controllers\ReporteProveedorController::class, 'generate'])->name('proveedores.reporte');

        // Articulos
        Route::resource('articulos', ArticuloController::class);
        Route::post('articulos/{articulo}/update-stock', [ArticuloController::class, 'updateStock'])->name('articulos.update-stock');
        Route::post('articulos/{articulo}/activate', [ArticuloController::class, 'activate'])->name('articulos.activate');
        Route::post('articulos/reporte/generar', [App\Http\Controllers\ReporteArticuloController::class, 'generate'])->name('articulos.reporte');
        
        // Compras (Reabastecimiento y Gestión)
        Route::get('compras', [CompraController::class, 'index'])->name('compras.index');
        Route::post('compras', [CompraController::class, 'store'])->name('compras.store');
        Route::get('compras/{compra}/download', [CompraController::class, 'downloadReceipt'])->name('compras.download');
        Route::get('compras/{compra}/print', [CompraController::class, 'printReceipt'])->name('compras.print');

        // Ventas (Análisis y Detalles)
        Route::get('ventas', [App\Http\Controllers\VentaController::class, 'index'])->name('ventas.index');


        // Devoluciones
        Route::get('devoluciones', [DevolucionController::class, 'index'])->name('devoluciones.index');
        Route::get('devoluciones/create', [DevolucionController::class, 'create'])->name('devoluciones.create');
        Route::post('devoluciones', [DevolucionController::class, 'store'])->name('devoluciones.store');
        Route::get('devoluciones/detalles/{factura}', [DevolucionController::class, 'getDetalles'])->name('devoluciones.detalles');

        // Rutas de CRUDs de Tablas Maestras
        // Ciudades
        Route::resource('ciudades', CiudadController::class);
        Route::post('ciudades/{ciudad}/activate', [CiudadController::class, 'activate'])->name('ciudades.activate');
        
        // Tipos de Documento
        Route::resource('tipos-documento', TipoDocumentoController::class)->parameters([
            'tipos-documento' => 'tiposDocumento'
        ]);
        Route::post('tipos-documento/{tiposDocumento}/activate', [TipoDocumentoController::class, 'activate'])->name('tipos-documento.activate');
        
        // Tipos de Artículo  
        Route::resource('tipos-articulo', TipoArticuloController::class)->parameters([
            'tipos-articulo' => 'tiposArticulo'
        ]);
        Route::post('tipos-articulo/{tiposArticulo}/activate', [TipoArticuloController::class, 'activate'])->name('tipos-articulo.activate');
        
        // Formas de Pago (Eliminado)
        /*
        Route::resource('formas-pago', FormaDePagoController::class)->parameters([
            'formas-pago' => 'formasPago'
        ]);
        Route::post('formas-pago/{formasPago}/activate', [FormaDePagoController::class, 'activate'])->name('formas-pago.activate');
        */

        // Reportes Centrales y Ventas
        Route::get('reportes', [App\Http\Controllers\ReporteCentralController::class, 'index'])->name('reportes.index');
        Route::get('reportes/rentabilidad-data', [App\Http\Controllers\ReporteCentralController::class, 'getRentabilidadData'])->name('reportes.rentabilidad-data');
        Route::post('reportes/rentabilidad/generar', [App\Http\Controllers\ReporteCentralController::class, 'generateRentabilidad'])->name('reportes.rentabilidad.generar');
        Route::post('ventas/reporte/generar', [App\Http\Controllers\ReporteVentaController::class, 'generate'])->name('ventas.reporte');
    });

    // Facturas (accessible by both administrators and clients)
    Route::get('facturas', [FacturaController::class, 'index'])->name('facturas.index');
    Route::get('facturas/create', [FacturaController::class, 'create'])->name('facturas.create')->middleware('App\Http\Middleware\IsAdministrator');
    Route::post('facturas', [FacturaController::class, 'store'])->name('facturas.store')->middleware('App\Http\Middleware\IsAdministrator');
    Route::get('facturas/{factura}', [FacturaController::class, 'show'])->name('facturas.show');
    Route::get('facturas/{factura}/print', [FacturaController::class, 'print'])->name('facturas.print');
    Route::get('facturas/{factura}/download', [FacturaController::class, 'download'])->name('facturas.download');
});
