<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subcategory;
use App\Models\Supplier;
use App\Models\Variant;
use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Mail\EnviarCotizacionMail;
use Illuminate\Support\Facades\Mail;

class GenerarCotizacion extends Command
{
    // Nombre y descripción del comando
    protected $signature = 'cotizaciones:generar';
    protected $description = 'Genera cotizaciones automáticas para productos con stock bajo';

    // Método handle() que ejecuta la lógica cuando se llama al comando
    public function handle()
{
    $this->info("Iniciando el proceso de generación de cotizaciones...");

    // Obtén todas las subcategorías
    $subcategories = Subcategory::all();

    // Recorremos cada subcategoría
    foreach ($subcategories as $subcategory) {
        // Creamos un array para agrupar las variantes por proveedor
        $variantesAgrupadas = [];

        // Recorremos los productos de la subcategoría
        foreach ($subcategory->products as $product) {
            // Recorremos las variantes del producto
            foreach ($product->variants as $variant) {
                // Verificar si el stock actual está por debajo del stock mínimo
                if ($variant->stock < $variant->stock_min) {
                    // Calculamos la cantidad a solicitar
                    $cantidadSolicitada = ceil(($variant->stock_min - $variant->stock) * 0.5);

                    // Obtenemos los proveedores asociados a esta subcategoría
                    $suppliers = Supplier::whereHas('subcategories', function ($query) use ($subcategory) {
                        $query->where('subcategory_id', $subcategory->id);
                    })->get();

                    // Agrupar variantes por proveedor
                    foreach ($suppliers as $supplier) {
                        // Agrupamos las variantes bajo el mismo proveedor
                        $variantesAgrupadas[$supplier->id][] = [
                            'variant_id' => $variant->id,
                            'cantidad_solicitada' => $cantidadSolicitada,
                        ];
                    }
                }
            }
        }

        // Generamos una cotización por proveedor con las variantes agrupadas
        foreach ($variantesAgrupadas as $supplierId => $variantes) {
            // Creamos la cotización para el proveedor
            $cotizacion = Cotizacion::create([
                'supplier_id' => $supplierId,
                'orden_compra_id' => null,
                'estado' => 'enviada',
            ]);

            // Agregamos los detalles de la cotización
            foreach ($variantes as $variante) {
                DetalleCotizacion::create([
                    'cotizacion_id' => $cotizacion->id,
                    'variant_id' => $variante['variant_id'],
                    'cantidad_solicitada' => $variante['cantidad_solicitada'],
                    'plazo_resp' => now()->addDays(7),
                    'precio' => null,
                    'cantidad' => null,
                    'tiempo_entrega' => null,
                ]);
            }

            // Enviar correo al proveedor
            $supplier = Supplier::find($supplierId);
            Mail::to($supplier->email)->send(new EnviarCotizacionMail($cotizacion));
        }
    }

    $this->info("Proceso de generación de cotizaciones finalizado.");
}
}
