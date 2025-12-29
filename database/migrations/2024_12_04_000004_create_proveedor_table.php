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
        Schema::create('proveedor', function (Blueprint $table) {
            $table->id();
            $table->string('nro_documento', 20);
            $table->foreignId('cod_tipo_documento')->constrained('tipo_documento');
            $table->string('nombre', 30);
            $table->string('apellido', 30);
            $table->foreignId('cod_ciudad')->constrained('ciudad');
            $table->string('direccion', 20)->nullable();
            $table->string('telefono', 15)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};
