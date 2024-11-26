<?php


namespace App\Http\Controllers;

use App\Http\Middleware\VerificarStock;

use Illuminate\Http\Request;

class CartController extends Controller
{

    public function __construct()
    {
        //LLAMO AL MIDDLEWARE que cree en la carpeta Middleware VerificarStock
        $this->middleware(VerificarStock::class);

    }

    public function index()
    {
        return view('cart.index');
    }
}
