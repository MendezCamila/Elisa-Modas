<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cotizacion;

class CotizacionController extends Controller
{
    //retornar la vista index
    public function index(){
        return view('admin.cotizaciones.index');
    }

    //retornar la vista create
    public function create(){
        return view('admin.cotizaciones.create');
    }

    //mostrar cotizacion al proveedor
    public function show($id)
    {
        return view('admin.cotizaciones.show', compact('id'));
    }

    // Mostrar cotización desde el panel de administración
    public function showAdmin($id)
    {
        $cotizacion = Cotizacion::with('detalleCotizaciones.variant', 'proveedor')->findOrFail($id);
        return view('admin.cotizaciones.show-admin', compact('cotizacion'));
    }

    // Mostrar respuesta del proveedor
    public function respuesta($id)
    {
        $cotizacion = Cotizacion::with('detalleCotizaciones.variant', 'proveedor')->findOrFail($id);
        return view('admin.cotizaciones.respuesta', compact('cotizacion'));
    }


}
