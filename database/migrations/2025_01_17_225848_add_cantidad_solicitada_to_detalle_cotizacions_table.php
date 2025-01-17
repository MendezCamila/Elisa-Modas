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
            $table->integer('cantidad_solicitada')->nullable()->after('cantidad')->comment('Cantidad de productos solicitada por el administrador');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_cotizacions', function (Blueprint $table) {
            $table->dropColumn('cantidad_solicitada');
        });
    }
};
