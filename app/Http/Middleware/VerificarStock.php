<?php

namespace App\Http\Middleware;

use App\Models\Variant;
use Closure;
use CodersFree\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarStock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Cart::instance('shopping');

        //recuperamos todos los elementos del carrito de compras
        foreach (Cart::content() as $item) {


            $options = $item->options;
            //recuperamos la variante del producto
            $variant = Variant::where('sku', $options ['sku'])
                ->first();

            $options['stock'] = $variant->stock;

            Cart::update($item->rowId, [
                'options' => $options
            ]  );

        }

        return $next($request);
    }
}
