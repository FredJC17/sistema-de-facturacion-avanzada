<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agregar campos subtotal e IGV a la tabla factura
     */
    public function up(): void
    {
        Schema::table('factura', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->default(0)->after('fecha_facturacion');
            $table->decimal('igv', 10, 2)->default(0)->after('subtotal');
            // El campo total_factura ya existe, será la suma de subtotal + igv
        });
    }

    /**
     * Revertir los cambios
     */
    public function down(): void
    {
        Schema::table('factura', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'igv']);
        });
    }
};
