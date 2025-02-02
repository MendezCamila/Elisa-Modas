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
            $table->boolean('disponible')->default(true); // La columna por defecto será 'true', indicando que el producto está disponible
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_cotizacions', function (Blueprint $table) {
            $table->dropColumn('disponible');
        });
    }
};
