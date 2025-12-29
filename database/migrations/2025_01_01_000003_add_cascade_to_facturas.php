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
        Schema::table('factura', function (Blueprint $table) {
            // Drop the existing foreign key (using standard naming convention)
            $table->dropForeign(['cod_cliente']);
            
            // Re-add with cascade
            $table->foreign('cod_cliente')
                  ->references('id')
                  ->on('cliente')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('factura', function (Blueprint $table) {
            $table->dropForeign(['cod_cliente']);
            
            // Revert to original (restrict is default behavior of constrained() without cascading)
            $table->foreign('cod_cliente')
                  ->references('id')
                  ->on('cliente');
        });
    }
};
