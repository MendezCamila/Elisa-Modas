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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();

            //relacion con la campaña de pre-venta
            $table->unsignedBigInteger('pre_venta_id');
            //Identificador del usuario que realiza la reserva
            $table->unsignedBigInteger('user_id');
            //cantidad reservada
            $table->integer('cantidad');
            //estado de la reserva: pendiente, confirmada, cancelada, etc.
            $table->string('estado')->default('pendiente');

            $table->timestamps();

            //clave foranea a pre_ventas
            $table->foreign('pre_venta_id')->references('id')->on('pre_ventas')->onDelete('cascade');
            // Clave foránea a users (opcional, según cómo manejes los clientes)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
