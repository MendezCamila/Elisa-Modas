<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Models\Supplier;
use App\Models\Variant;
use App\Models\OrdenCompra;

class OrdenCompraController extends Controller
{
    //retornar la vista index
    public function index(){
        return view('admin.orden-compras.index');
    }

    public function create($id){

        //$cotizacion = Cotizacion::with('detalleCotizaciones.variant', 'proveedor')->findOrFail($id);

        $cotizacion = Cotizacion::with(['detalleCotizaciones.variant.features','detalleCotizaciones.variant.product'])->findOrFail($id);
        return view('admin.orden-compras.create', compact('cotizacion'));
    }

    public function show($id){
        $ordenCompra = OrdenCompra::with(['detalleOrdenCompras.variant.product', 'proveedor'])->findOrFail($id);
        return view('admin.orden-compras.show', compact('ordenCompra'));
    }

    /*retornar la vista create
    public function create(){
        return view('admin.orden-compras.create');
    }*/

    public function showAdmin ($id){
        $ordenCompra = OrdenCompra::with(['detalleOrdenCompras.variant.product', 'proveedor'])->findOrFail($id);
        return view('admin.orden-compras.showAdmin', compact('ordenCompra'));
    }




}
