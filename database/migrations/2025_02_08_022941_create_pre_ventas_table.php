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
        Schema::create('pre_ventas', function (Blueprint $table) {
            $table->id();
            //Relacion con la tabla de variantes
            $table->unsignedBigInteger('variant_id');


            //cantidad asignada para la pre-venta (pool)
            $table->integer('cantidad');

            //descuento o precio especial (puede ser porcentaje o monto fijo)
            $table->decimal('descuento', 10, 2)->nullable();

            //fecha de inicio y fin de la campaña
            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            // Estado de la campaña: active, disponible, finalizada, etc.
            $table->string('estado')->default('active');

            $table->timestamps();

            //clave foranea: si se elimina la variante se eliminan las campañas asociadas
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_ventas');
    }
};
