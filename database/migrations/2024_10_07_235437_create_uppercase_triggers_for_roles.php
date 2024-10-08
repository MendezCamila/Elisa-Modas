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
        // Crear triggers para convertir a mayúsculas antes de insertar o actualizar
        DB::statement(
            'CREATE OR REPLACE TRIGGER insert_uppercase_role_name' .
            ' BEFORE INSERT ON roles' .
            ' FOR EACH ROW BEGIN' .
            ' SET NEW.name = UPPER(NEW.name);' .
            ' END'
        );
        DB::statement(
            'CREATE OR REPLACE TRIGGER update_uppercase_role_name' .
            ' BEFORE UPDATE ON roles' .
            ' FOR EACH ROW BEGIN' .
            ' SET NEW.name = UPPER(NEW.name);' .
            ' END'
        );

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
        DB::statement(
            'DROP TRIGGER IF EXISTS update_uppercase_role_name;'
        );
        DB::statement(
            'DROP TRIGGER IF EXISTS insert_uppercase_role_name;'
        );
    }
};
