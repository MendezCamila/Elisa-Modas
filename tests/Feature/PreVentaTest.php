<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Variant;
use App\Models\PreVenta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class PreVentaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registrar_recepcion_actualiza_el_stock_y_estado_de_la_preventa_y_variante()
    {
        // Creamos un producto de prueba
        $product = Product::factory()->create();

        // Creamos una variante para ese producto con stock 0 y estado "preventa"
        $variant = Variant::factory()->create([
            'product_id' => $product->id,
            'stock'      => 0,
            'estado'     => 'preventa',
        ]);

        // Creamos una pre-venta asociada a esa variante.
        // Usamos un pool (cantidad ofertada) de 100 unidades y estado "activo"
        $preVenta = PreVenta::factory()->create([
            'variant_id'  => $variant->id,
            'cantidad'    => 100,   // Pool definido para la pre-venta
            'descuento'   => 20,    // Por ejemplo, 20%
            'fecha_inicio'=> Carbon::now()->subDay(),
            'fecha_fin'   => Carbon::now()->addDay(),
            'estado'      => 'activo',
        ]);

        // Simulamos la recepción de 70 unidades mediante una solicitud POST
        $response = $this->post(route('admin.pre-ventas.registerReception', $preVenta), [
            'cantidadRecibida' => 70,
        ]);

        // Refrescamos las instancias para obtener los valores actualizados
        $variant->refresh();
        $preVenta->refresh();

        // Se espera que, sin reservas (ya que en este test no creamos reservas),
        // el stock de la variante se actualice a 70 y su estado a "disponible".
        $this->assertEquals(70, $variant->stock);
        $this->assertEquals('disponible', $variant->estado);

        // La pre-venta debe cambiar a "disponible"
        $this->assertEquals('disponible', $preVenta->estado);

        // Verificamos que la respuesta redirija a la ruta de listado de pre-ventas y tenga un mensaje de éxito
        $response->assertRedirect(route('admin.pre-ventas.index'));
        $response->assertSessionHas('swal');
    }
}

