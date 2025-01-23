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
            // Añadir la nueva columna 'plazo_resp'
            $table->date('plazo_resp')->after('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_cotizacions', function (Blueprint $table) {
            // Eliminar la columna 'plazo_resp'
            $table->dropColumn('plazo_resp');
        });
    }
};
