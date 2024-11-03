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
        Schema::create('detalle_orden_compras', function (Blueprint $table) {
            $table->id();
            //cantidad
            $table->integer('cantidad');
            //precio unitario
            $table->decimal('precio_unitario', 10, 2);
            $table->timestamps();

            //foreign key orden_compra
            $table->foreignId('orden_compra_id')
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
        Schema::dropIfExists('detalle_orden_compras');
    }
};
