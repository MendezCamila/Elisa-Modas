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
        // Convertir los nombres de los roles existentes a mayúsculas
        DB::table('roles')->get()->each(function ($role) {
            DB::table('roles')
                ->where('id', $role->id)
                ->update([
                    'name' => strtoupper($role->name),
                ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No es necesario revertir esta migración
    }
};
