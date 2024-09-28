<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creamos un rol
        $admin = Role::create(['name' => 'admin']);

        //asignamos todos los permisos al rol admin
        $admin->syncPermissions([
            'acceso dashboard',
            'administrar opciones',
            'administrar familias',
            'administrar categorias',
            'administrar subcategorias',
            'administrar productos',
            'administrar portadas',
            'administrar usuarios',
        ]);

        //recuperamos el usuario al cual le queremos dar el rol
        $user= User::find(1);
        //acceso al usuario y le paso el rol
        $user->assignRole('admin');

        //creamos otro rol


    }
}
