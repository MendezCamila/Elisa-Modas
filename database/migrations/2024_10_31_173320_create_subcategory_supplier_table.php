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
        Schema::create('subcategory_supplier', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            //foreign key supplier
            $table->foreignId('supplier_id')
                ->constrained();

            //foreign key subcategory
            $table->foreignId('subcategory_id')
                ->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategory_supplier');
    }
};
