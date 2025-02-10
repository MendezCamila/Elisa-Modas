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
        Schema::table('pre_ventas', function (Blueprint $table) {
            // Cambiar el tipo de columna 'descuento' a integer para manejarlo como porcentaje
            $table->integer('descuento')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_ventas', function (Blueprint $table) {
            // Revertir el cambio de tipo de columna 'descuento' a decimal
            $table->decimal('descuento', 10, 2)->change();
        });
    }
};
