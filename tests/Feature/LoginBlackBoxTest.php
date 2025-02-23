<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginBlackBoxTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function la_pantalla_de_login_se_muestra_correctamente()
    {
        // Realizamos una solicitud GET a la ruta /login
        $response = $this->get('/login');

        // Verificamos que la respuesta tenga el código 200
        $response->assertStatus(200);

        // Podemos verificar que el contenido tenga alguna cadena que identifique la página de login
        $response->assertSee('Iniciar sesión');
    }

    /** @test */
    public function usuarios_con_credenciales_validas_se_autentican_y_son_redirigidos_al_dashboard()
    {
        // Creamos un usuario de prueba (sin preocuparse por la implementación interna)
        $user = User::factory()->create([
            'email' => 'usuario@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Simulamos un POST a la ruta de login con credenciales válidas
        $response = $this->post('/login', [
            'email' => 'usuario@example.com',
            'password' => 'password123',
        ]);

        // Verificamos que la respuesta sea un redireccionamiento al dashboard
        $response->assertRedirect('/dashboard');

        // Además, podemos verificar que el usuario quedó autenticado
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function usuarios_con_credenciales_invalidas_no_se_autentican()
    {
        // Creamos un usuario de prueba
        $user = User::factory()->create([
            'email' => 'usuario@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Simulamos un POST a la ruta de login con credenciales incorrectas
        $response = $this->post('/login', [
            'email' => 'usuario@example.com',
            'password' => 'claveIncorrecta',
        ]);

        // Verificamos que la respuesta no redirige al dashboard
        $response->assertStatus(302); // Probablemente redirige de vuelta a login con errores

        // Verificamos que no se haya autenticado
        $this->assertGuest();
    }
}
