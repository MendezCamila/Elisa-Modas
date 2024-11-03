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
        Schema::create('detalle_cotizacions', function (Blueprint $table) {
            $table->id();
            //precio
            $table->decimal('precio', 10, 2);
            //cantidad
            $table->integer('cantidad');
            //tiempo entrega
            $table->string('tiempo_entrega');
            $table->timestamps();

            //foreign key cotizacion
            $table->foreignId('cotizacion_id')
                ->constrained();

            //foreign key variant
            $table->foreignId('variant_id')
                ->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_cotizacions');
    }
};
