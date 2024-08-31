<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    //definimos el metodo show
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }
}
