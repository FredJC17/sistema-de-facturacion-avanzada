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
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('documento', 15)->unique();
            $table->foreignId('cod_tipo_documento')->constrained('tipo_documento');
            $table->string('nombre', 30);
            $table->string('apellido', 30);
            $table->string('direccion', 20)->nullable();
            $table->foreignId('cod_ciudad')->constrained('ciudad');
            $table->string('telefono', 15)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('rol', ['administrator', 'client'])->default('client');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
