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
        Schema::table('detalle_cotizacions', function (Blueprint $table) {
            // Hacemos que las columnas permitan valores NULL
            $table->decimal('precio', 8, 2)->nullable()->change();
            $table->integer('cantidad')->nullable()->change();
            $table->integer('tiempo_entrega')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_cotizacions', function (Blueprint $table) {
            // Revertir a no permitir NULL si es necesario
            $table->decimal('precio', 8, 2)->nullable(false)->change();
            $table->integer('cantidad')->nullable(false)->change();
            $table->integer('tiempo_entrega')->nullable(false)->change();
        });
    }
};
