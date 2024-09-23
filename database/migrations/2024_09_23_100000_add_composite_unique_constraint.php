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
        Schema::table('families', function (Blueprint $table) {
            $table->unique(['name']);
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['family_id']);
            $table->foreign('family_id')
            ->references('id')
            ->on('families')
            ->onDelete('restrict');
            $table->unique(['family_id', 'name']);
        });
        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('restrict');
            $table->unique(['category_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subcategories', function (Blueprint $table) {
            $table->dropUnique(['category_id', 'name']);
            $table->dropForeign(['category_id']);
            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('cascade');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique(['family_id', 'name']);
            $table->dropForeign(['family_id']);
            $table->foreign('family_id')
            ->references('id')
            ->on('families')
            ->onDelete('cascade');
        });
        Schema::table('families', function (Blueprint $table) {
            $table->dropUnique(['name']);
        });
    }
};
