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
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();
            //precio total
            $table->decimal('total', 10, 2);
            //tiempo entrega
            $table->string('tiempo_entrega');
            $table->timestamps();

            //foreign key supplier
            $table->foreignId('supplier_id')
                ->constrained();

            //foreign key orden_compra
            $table->foreignId('orden_compra_id')
                ->constrained();



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacions');
    }
};
