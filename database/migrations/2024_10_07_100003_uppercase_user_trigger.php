<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement(
            'CREATE OR REPLACE TRIGGER insert_uppercase_user_fields' .
            ' BEFORE INSERT ON users' .
            ' FOR EACH ROW BEGIN' .
            ' SET NEW.name = UPPER(NEW.name);' .
            ' SET NEW.last_name = UPPER(NEW.last_name);' .
            ' SET NEW.phone = UPPER(NEW.phone);' .
            ' END'
        );
        DB::statement(
            'CREATE OR REPLACE TRIGGER update_uppercase_user_fields' .
            ' BEFORE UPDATE ON users' .
            ' FOR EACH ROW BEGIN' .
            ' SET NEW.name = UPPER(NEW.name);' .
            ' SET NEW.last_name = UPPER(NEW.last_name);' .
            ' SET NEW.phone = UPPER(NEW.phone);' .
            ' END'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(
            'DROP TRIGGER IF EXISTS update_uppercase_user_fields;'
        );
        DB::statement(
            'DROP TRIGGER IF EXISTS insert_uppercase_user_fields;'
        );
    }
};
