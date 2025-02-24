<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\UploadedFile;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void {
        parent::setUp();

        // Crear rol "Administrador" y permiso "administrar productos"
        $rol = Role::create(['name' => 'Administrador']);
        $permiso = Permission::create(['name' => 'administrar productos']);
        $rol->givePermissionTo($permiso);

        // Crear y autenticar un usuario con el rol de Administrador
        $this->user = User::factory()->create();
        $this->user->assignRole($rol);
    }

    /** @test
     * Verifica que se crea un producto con datos válidos.
     * Envía una solicitud POST a /admin/products con un array "product" que contiene:
     *  - name: "Producto de Prueba"
     *  - sku: "PROD123"
     *  - price: 100
     *  - descripcion: "Este es un producto de prueba"
     *  - subcategory_id: (el id de una subcategoría creada)
     * Además, se envía un archivo simulado de imagen.
     *
     * Se espera que la respuesta sea una redirección (302) y que en la base de datos exista el producto.
     */
    public function se_crea_un_producto_con_datos_validos()
    {
        $this->actingAs($this->user);

        // Crear una subcategoría para asociar al producto
        $subcategoria = Subcategory::factory()->create();

        $response = $this->post('/admin/products', [
            'product' => [
                'name' => 'Producto de Prueba',
                'sku' => 'PROD123',
                'price' => 100,
                'descripcion' => 'Este es un producto de prueba',
                'subcategory_id' => $subcategoria->id,
            ],
            // Se simula un archivo de imagen sin utilizar GD
            'image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
        ]);

        // Se espera una redirección (302) o status 200 según la implementación
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', ['name' => 'Producto de Prueba']);
    }

    /** @test
     * Verifica que el campo "name" es obligatorio.
     * Se envía la solicitud sin "product.name" y se espera que se genere un error en la sesión.
     */
    public function se_requiere_un_nombre()
    {
        $this->actingAs($this->user);
        $subcategoria = Subcategory::factory()->create();

        $response = $this->post('/admin/products', [
            'product' => [
                // Se omite el campo "name"
                'sku' => 'PROD123',
                'price' => 100,
                'descripcion' => 'Este es un producto de prueba',
                'subcategory_id' => $subcategoria->id,
            ],
            'image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertSessionHasErrors('product.name');
    }

    /** @test
     * Verifica que el campo "price" es obligatorio.
     */
    public function se_requiere_un_precio()
    {
        $this->actingAs($this->user);
        $subcategoria = Subcategory::factory()->create();

        $response = $this->post('/admin/products', [
            'product' => [
                'name' => 'Producto de Prueba',
                'sku' => 'PROD123',
                // Se omite "price"
                'descripcion' => 'Este es un producto de prueba',
                'subcategory_id' => $subcategoria->id,
            ],
            'image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertSessionHasErrors('product.price');
    }

    /** @test
     * Verifica que el campo "descripcion" es obligatorio.
     */
    public function se_requiere_una_descripcion()
    {
        $this->actingAs($this->user);
        $subcategoria = Subcategory::factory()->create();

        $response = $this->post('/admin/products', [
            'product' => [
                'name' => 'Producto de Prueba',
                'sku' => 'PROD123',
                'price' => 100,
                // Se omite "descripcion"
                'subcategory_id' => $subcategoria->id,
            ],
            'image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertSessionHasErrors('product.descripcion');
    }
}

