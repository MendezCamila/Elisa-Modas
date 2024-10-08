<?php

namespace App\Observers;

use App\Models\Variant;
use App\Models\Product;

class VariantObserver
{
    /**
     * Handle the Variant "created" event.
     */
    public function created(Variant $variant): void
    {
        //Preguntamos si el producto no tiene opciones
        if ($variant->product->options->count() == 0) {

            //Asignamos el sku del producto al sku de la variante
            $variant->sku = $variant->product->sku;
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
