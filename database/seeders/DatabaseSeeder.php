<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        Storage::deleteDirectory('products');
        Storage::makeDirectory('products');
        // User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Camila Itati',
            'last_name' => 'Mendez',
            'email' => 'mendezcamilaitati@gmail.com',
            'phone' => '3756492243',
            'password' => bcrypt('Camila492243')
        ]);



        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            FamilySeeder::class,
            OptionSeeder::class,
        ]);

        Product::factory(10)->create();
    }
}
