<?php

namespace App\Http\Controllers;
use App\Models\Cover;
use App\Models\Product;
use App\Models\PreVenta;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        //Recuperamos todas las portadas
        $covers = Cover::where('is_active', true)
            ->whereDate('start_at', '<=', now())
            ->where(function($query){
                $query->whereDate('end_at', '>=', now())
                    ->orWhereNull('end_at');
            })
            ->get();

        // Recuperamos los productos para venta normal:
        // Aquellos que tienen al menos una variante con stock > 0 y estado "disponible"
        $normalProducts = Product::whereHas('variants', function($query) {
            $query->where('stock', '>', 0)
                  ->where('estado', 'disponible');
        })
        ->orderBy('created_at', 'desc')
        ->take(12)
        ->get();

        // Recuperamos los productos en pre-venta activa:
        // Se consideran las pre-ventas que estén activas o que estén dentro del rango de fechas (fecha_inicio y fecha_fin)
        // y cuya variante tenga stock 0 y estado "preventa"
        $preVentaProducts = PreVenta::where(function($query) {
                $query->where('estado', 'activo')
                      ->orWhere(function($query) {
                          $query->whereDate('fecha_inicio', '<=', now())
                                ->whereDate('fecha_fin', '>=', now());
                      });
            })
            ->whereHas('variant', function($query) {
                $query->where('stock', 0)
                      ->where('estado', 'preventa');
            })
            ->with('variant.product')
            ->get()
            ->map(function ($preVenta) {
                $product = $preVenta->variant->product;
                // Agregamos propiedades para usarlas en la vista
                $product->is_preventa = true;
                $product->preventa_descuento = $preVenta->descuento;
                return $product;
            });

        // Combinamos las dos colecciones y ordenamos para que los productos en pre-venta aparezcan primero
        $products = $preVentaProducts->merge($normalProducts)
            ->sortByDesc(function ($product) {
                return $product->is_preventa ? 1 : 0;
            });

        return view('welcome', compact('covers', 'products'));
    }
}
