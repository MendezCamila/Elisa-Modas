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
            'CREATE OR REPLACE TRIGGER' .
            ' insert_uppercase_family_name' .
            ' BEFORE INSERT ON families' .
            ' FOR EACH ROW BEGIN' .
            ' SET NEW.name = UPPER(NEW.name); END'
        );
        DB::statement(
            'CREATE OR REPLACE TRIGGER' .
            ' update_uppercase_family_name' .
            ' BEFORE UPDATE ON families' .
            ' FOR EACH ROW BEGIN' .
            ' SET NEW.name = UPPER(NEW.name); END'
        );
        DB::statement(
            'CREATE OR REPLACE TRIGGER' .
            ' insert_uppercase_category_name' .
            ' BEFORE INSERT ON categories' .
            ' FOR EACH ROW BEGIN' .
            ' SET NEW.name = UPPER(NEW.name); END'
        );
        DB::statement(
            'CREATE OR REPLACE TRIGGER' .
            ' update_uppercase_category_name' .
            ' BEFORE UPDATE ON categories' .
            ' FOR EACH ROW BEGIN' .
            ' SET NEW.name = UPPER(NEW.name); END'
        );
        DB::statement(
            'CREATE OR REPLACE TRIGGER' .
            ' insert_uppercase_subcategory_name' .
            ' BEFORE INSERT ON subcategories' .
            ' FOR EACH ROW BEGIN' .
            ' SET NEW.name = UPPER(NEW.name); END'
        );
        DB::statement(
            'CREATE OR REPLACE TRIGGER' .
            ' update_uppercase_subcategory_name' .
            ' BEFORE UPDATE ON subcategories' .
            ' FOR EACH ROW BEGIN' .
            ' SET NEW.name = UPPER(NEW.name); END'
        );
        DB::statement(
            'CREATE OR REPLACE TRIGGER' .
            ' insert_uppercase_product_name' .
            ' BEFORE INSERT ON products' .
            ' FOR EACH ROW BEGIN' .
            ' SET NEW.name = UPPER(NEW.name); END'
        );
        DB::statement(
            'CREATE OR REPLACE TRIGGER' .
            ' update_uppercase_product_name' .
            ' BEFORE UPDATE ON products' .
            ' FOR EACH ROW BEGIN' .
            ' SET NEW.name = UPPER(NEW.name); END'
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement(
            'DROP TRIGGER IF EXISTS' .
            ' update_uppercase_product_name;'
        );
        DB::statement(
            'DROP TRIGGER IF EXISTS' .
            ' insert_uppercase_product_name;'
        );
        DB::statement(
            'DROP TRIGGER IF EXISTS' .
            ' update_uppercase_subcategory_name;'
        );
        DB::statement(
            'DROP TRIGGER IF EXISTS' .
            ' insert_uppercase_subcategory_name;'
        );
        DB::statement(
            'DROP TRIGGER IF EXISTS' .
            ' update_uppercase_category_name;'
        );
        DB::statement(
            'DROP TRIGGER IF EXISTS' .
            ' insert_uppercase_category_name;'
        );
        DB::statement(
            'DROP TRIGGER IF EXISTS' .
            ' update_uppercase_family_name;'
        );
        DB::statement(
            'DROP TRIGGER IF EXISTS' .
            ' insert_uppercase_family_name;'
        );
    }
};
