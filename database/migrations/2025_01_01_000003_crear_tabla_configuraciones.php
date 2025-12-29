<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear tabla de configuraciones para almacenar preferencias de usuario
     */
    public function up(): void
    {
        Schema::create('configuraciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cod_usuario');
            $table->enum('tema', ['claro', 'oscuro'])->default('claro');
            $table->string('idioma', 5)->default('es');
            $table->timestamps();

            // Relación con la tabla cliente (usuarios)
            $table->foreign('cod_usuario')->references('id')->on('cliente')->onDelete('cascade');
            
            // Un usuario solo puede tener una configuración
            $table->unique('cod_usuario');
        });
    }

    /**
     * Revertir los cambios
     */
    public function down(): void
    {
        Schema::dropIfExists('configuraciones');
    }
};
