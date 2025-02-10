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

        //recuperamos los ultimos productos creados
        $lastProducts = Product::orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        //recuperamos los productos en pre-venta
        $preVentaProducts = PreVenta::where('estado', 'activo')
            ->with('variant.product')
            ->get()
            ->map(function ($preVenta) {
                $product = $preVenta->variant->product;
                $product->is_preventa = true;
                $product->preventa_descuento = $preVenta->descuento;
                return $product;
            });

        // Combinamos los productos normales y los de pre-venta
        $products = $lastProducts->merge($preVentaProducts);


        //Retornamos la vista welcome con las portadas
        return view('welcome', compact('covers', 'products'));
    }
}
