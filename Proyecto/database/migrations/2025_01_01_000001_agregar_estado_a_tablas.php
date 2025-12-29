<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Agregar campo estado solo a las tablas que no lo tienen
        
        // Verificar y agregar a ciudad
        if (!Schema::hasColumn('ciudad', 'estado')) {
            Schema::table('ciudad', function (Blueprint $table) {
                $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            });
        }

        // Cliente ya tiene estado en la migración original, no agregar

        // Verificar y agregar a proveedor
        if (!Schema::hasColumn('proveedor', 'estado')) {
            Schema::table('proveedor', function (Blueprint $table) {
                $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            });
        }

        // Verificar y agregar a articulo
        if (!Schema::hasColumn('articulo', 'estado')) {
            Schema::table('articulo', function (Blueprint $table) {
                $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            });
        }

        // Verificar y agregar a tipo_documento
        if (!Schema::hasColumn('tipo_documento', 'estado')) {
            Schema::table('tipo_documento', function (Blueprint $table) {
                $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            });
        }

        // Verificar y agregar a tipo_articulo
        if (!Schema::hasColumn('tipo_articulo', 'estado')) {
            Schema::table('tipo_articulo', function (Blueprint $table) {
                $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            });
        }

        // Verificar y agregar a forma_de_pago
        if (!Schema::hasColumn('forma_de_pago', 'estado')) {
            Schema::table('forma_de_pago', function (Blueprint $table) {
                $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            });
        }

        // Verificar y agregar a factura
        if (!Schema::hasColumn('factura', 'estado')) {
            Schema::table('factura', function (Blueprint $table) {
                $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            });
        }

        // Verificar y agregar a devolucion
        if (!Schema::hasColumn('devolucion', 'estado')) {
            Schema::table('devolucion', function (Blueprint $table) {
                $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            });
        }
    }

    public function down(): void
    {
        $tablas = ['ciudad', 'proveedor', 'articulo', 'tipo_documento', 'tipo_articulo', 'forma_de_pago', 'factura', 'devolucion'];
        
        foreach ($tablas as $tabla) {
            if (Schema::hasColumn($tabla, 'estado')) {
                Schema::table($tabla, function (Blueprint $table) {
                    $table->dropColumn('estado');
                });
            }
        }
    }
};
