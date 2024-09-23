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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['subcategory_id']);
            $table->foreign('subcategory_id')
            ->references('id')
            ->on('subcategories')
            ->onDelete('restrict');
            $table->unique(['subcategory_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['subcategory_id', 'name']);
            $table->dropForeign(['subcategory_id']);
            $table->foreign('subcategory_id')
            ->references('id')
            ->on('subcategories')
            ->onDelete('cascade');
        });
    }
};
