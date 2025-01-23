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
        Schema::table('cotizacions', function (Blueprint $table) {
            // Eliminar las columnas 'total' y 'tiempo_entrega'
            $table->dropColumn(['total', 'tiempo_entrega']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            // Restaurar las columnas eliminadas
            $table->decimal('total', 10, 2)->nullable();
            $table->integer('tiempo_entrega')->nullable();
        });
    }
};
