<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear rol y permiso para la prueba
        $role = Role::create(['name' => 'Administrador']);
        $permission = Permission::create(['name' => 'administrar productos']);
        $role->givePermissionTo($permission);

        // Crear y autenticar usuario con el rol adecuado
        $this->user = User::factory()->create();
        $this->user->assignRole($role);
    }

    /** @test */
    public function it_creates_a_product()
    {
        $this->actingAs($this->user); // Autenticar usuario en la prueba

        // Crear una subcategoría antes de usarla
        $subcategory = Subcategory::factory()->create();

        $response = $this->postJson('/admin/products', [
            'name' => 'Test Product',
            'sku' => 'PROD123',
            'price' => 100,
            'description' => 'This is a test product',
            'image_path' => 'images/remera.jpg',
            'subcategory_id' => $subcategory->id,
        ]);

        $response->assertStatus(201); // Código 201 significa "Creado"
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    /** @test */
    public function it_requires_a_name()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/admin/products', [
            'price' => 100,
            'description' => 'This is a test product',
            'subcategory_id' => 1,
        ]);

        $response->assertStatus(422) // Código 422 = error de validación
                 ->assertJsonValidationErrors('name');
    }

    /** @test */
    public function it_requires_a_price()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/admin/products', [
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'subcategory_id' => 1,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('price');
    }

    /** @test */
    public function it_requires_a_description()
    {
        $this->actingAs($this->user);

        $response = $this->postJson('/admin/products', [
            'name' => 'Test Product',
            'price' => 100,
            'subcategory_id' => 1,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('description');
    }
}
