<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Models\Supplier;
use App\Models\Variant;

class OrdenCompraController extends Controller
{
    //retornar la vista index
    public function index(){
        return view('admin.orden-compras.index');
    }

    public function create($cotizacion_id){
        $cotizacion = Cotizacion::with('detalleCotizaciones.variant.product')->findOrFail($cotizacion_id);
        $suppliers = Supplier::all();
        $variants = Variant::all();
        return view('admin.orden-compras.create', compact('cotizacion', 'suppliers', 'variants'));
    }

    /*retornar la vista create
    public function create(){
        return view('admin.orden-compras.create');
    }*/




}
