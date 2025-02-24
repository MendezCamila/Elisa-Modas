<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Supplier;
use App\Models\Variant;
use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Mail\EnviarCotizacionMail;
use Illuminate\Support\Facades\Mail;

class GenerarCotizacion extends Command
{
    protected $signature = 'cotizaciones:generar';
    protected $description = 'Genera cotizaciones automáticas para productos con stock bajo';

    public function handle()
    {
        $this->info("Iniciando el proceso de generación de cotizaciones...");

        // Obtener todos los proveedores
        $suppliers = Supplier::with('subcategories.products.variants')->get();

        // Array para agrupar variantes por proveedor
        $cotizacionesPorProveedor = [];

        foreach ($suppliers as $supplier) {
            foreach ($supplier->subcategories as $subcategory) {
                foreach ($subcategory->products as $product) {
                    foreach ($product->variants as $variant) {
                        // Verificar si el stock está por debajo del mínimo
                        if ($variant->stock < $variant->stock_min) {
                            $cantidadSolicitada = ($variant->stock_min - $variant->stock) + 15;

                            // Agrupar variantes por proveedor
                            $cotizacionesPorProveedor[$supplier->id][] = [
                                'variant_id' => $variant->id,
                                'cantidad_solicitada' => $cantidadSolicitada,
                            ];
                        }
                    }
                }
            }
        }

        // Generar una cotización única para cada proveedor con todos los productos con stock bajo
        foreach ($cotizacionesPorProveedor as $supplierId => $variantes) {
            $cotizacion = Cotizacion::create([
                'supplier_id' => $supplierId,
                'orden_compra_id' => null,
                'estado' => 'enviada',
            ]);

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

            // Enviar email al proveedor
            $supplier = Supplier::find($supplierId);
            Mail::to($supplier->email)->send(new EnviarCotizacionMail($cotizacion));

            $this->info("Cotización enviada a {$supplier->email} con " . count($variantes) . " productos.");
        }

        $this->info("Proceso de generación de cotizaciones finalizado.");
    }
}
