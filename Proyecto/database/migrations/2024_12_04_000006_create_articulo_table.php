<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articulo', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 40);
            $table->integer('precio_venta');
            $table->integer('precio_costo');
            $table->integer('stock')->default(0);
            $table->foreignId('cod_proveedor')->constrained('proveedor');
            $table->foreignId('cod_tipo_articulo')->constrained('tipo_articulo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulo');
    }
};
