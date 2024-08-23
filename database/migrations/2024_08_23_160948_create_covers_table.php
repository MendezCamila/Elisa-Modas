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
        Schema::create('covers', function (Blueprint $table) {
            $table->id();

            $table->string('image_path');
            //para el nombre de la portada
            $table->string('title');

            //la fecha desde cuando queremos que tenga vigencia esa portada
            $table->datetime('start_at');

            //hasta cuando queremos que esa imagen sea publica
            $table->datetime('end_at')->nullable();

            //para determinar si una imagen se encuentra o no activa
            $table->boolean('is_active')->default(true);

            //para el orden de las imagenes
            $table->integer('order')->default(0);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('covers');
    }
};
