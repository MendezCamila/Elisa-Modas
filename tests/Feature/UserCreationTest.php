<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCreationTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function se_puede_crear_un_usuario_con_datos_validos()
    {
        //definimos datos de prueba
        $data = [
            'name' => 'Juan',
            'last_name' => 'Perez',
            'email' => 'juan@example.com',
            'phone' => '1234567890',
            'password' => bcrypt('password'),
        ];

        // Ejecutamos la acción: creamos el usuario
        $user = User::create($data);


        // Verificamos que el usuario se haya creado
        $this->assertDatabaseHas('users', [
            'name' => 'Juan',
            'last_name' => 'Perez',
            'email' => 'juan@example.com',
            'phone' => '1234567890',
            ]);
        }
    }
