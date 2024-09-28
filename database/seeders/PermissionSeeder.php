<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //array con todos los permisos
        $permissions=[
            'acceso dashboard',
            'administrar opciones',
            'administrar familias',
            'administrar categorias',
            'administrar subcategorias',
            'administrar productos',
            'administrar portadas',
            'administrar usuarios',
        ];

        //recorremos el array y creamos los permisos
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
