<?php

namespace App\Observers;

use App\Models\Variant;
use App\Models\Product;

class VariantObserver
{
    /**
     * Handle the Variant "created" event.
     */

    /* CODIGO QUE FUNCIONA
    public function created(Variant $variant): void
    {
        //Preguntamos si el producto no tiene opciones
        if ($variant->product->options->count() == 0) {

            //Asignamos el sku del producto al sku de la variante
            $variant->sku = $variant->product->sku;
            $variant->save();


        }

    }*/

    /* CODIGO QUE FUNCIONA UN POQUITO MEJOR
    public function created(Variant $variant): void
    {
        // Verificamos si la variante creada es la primera (la principal) para este producto
        if ($variant->product->variants->count() == 1) {
            // Asignamos el SKU y la imagen del producto a esta variante principal
            $variant->sku = $variant->product->sku;
            $variant->image_path = $variant->product->image_path; // Asignamos la imagen del producto
            $variant->save();
        }
    }*/

    public function created(Variant $variant): void
    {
        // Verificamos si el producto no tiene opciones y esta es la primera variante
        if ($variant->product->options->count() == 0 && $variant->product->variants->count() == 1) {
            // Asignamos el SKU y la imagen del producto solo si no tiene opciones
            $variant->sku = $variant->product->sku;
            $variant->image_path = $variant->product->image_path; // Asignamos la imagen del producto
            $variant->save();
        }
    }

    /**
     * Handle the Variant "updated" event.
     */
    public function updated(Variant $variant): void
    {
        //
    }

    /**
     * Handle the Variant "deleted" event.
     */
    public function deleted(Variant $variant): void
    {
        //
    }

    /**
     * Handle the Variant "restored" event.
     */
    public function restored(Variant $variant): void
    {
        //
    }

    /**
     * Handle the Variant "force deleted" event.
     */
    public function forceDeleted(Variant $variant): void
    {
        //
    }
}
