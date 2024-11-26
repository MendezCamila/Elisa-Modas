<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subcategory;
use App\Models\Supplier;
use App\Models\Variant;

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
            //$this->info("Procesando subcategoría: " . $subcategory->name);

            // Para cada subcategoría, obtenemos los productos
            foreach ($subcategory->products as $product) {
                //$this->info("  Procesando producto: " . $product->name);

                // Para cada producto, obtenemos sus variantes
                foreach ($product->variants as $variant) {
                    // Comprobamos si el stock actual es menor que el stock mínimo
                    if ($variant->stock < $variant->stock_min) {
                        //$this->info("    Variante con stock bajo detectada: " . $variant->sku);

                        // Calculamos el 50% del stock mínimo para reponer
                        $cantidadSolicitada = ceil(($variant->stock_min - $variant->stock) * 0.5);

                        // Encontramos los proveedores asociados a la subcategoría de este producto
                        $suppliers = Supplier::whereHas('subcategories', function ($query) use ($subcategory) {
                            $query->where('subcategory_id', $subcategory->id);
                        })->get();

                        // Mostrar la información solicitada: producto, variante, stock mínimo, cantidad solicitada y proveedor
                        foreach ($suppliers as $supplier) {
                            // Mostramos la información en consola solo para variantes con stock bajo
                            $this->info("      Producto: " . $product->name);
                            $this->info("      Codigo Variante con stock bajo: " . $variant->sku);
                            $this->info("      Stock mínimo: " . $variant->stock_min);
                            $this->info("      Cantidad a solicitar: " . $cantidadSolicitada);
                            $this->info("      Proveedor: " . $supplier->name);
                            $this->info("      ---------------------------------");
                        }
                    }
                }
            }
        }

        $this->info("Proceso de generación de cotizaciones finalizado.");
    }
}
