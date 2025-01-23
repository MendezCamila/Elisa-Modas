<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    /* Actualizar la cotización con los datos del proveedor
    public function update(Request $request, $id)
    {
        $request->validate([
            'detalles.*.precio' => 'required|numeric|min:0',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.tiempo_entrega' => 'required|integer|min:1',
        ]);

        foreach ($request->detalles as $detalle) {
            $detalleCotizacion = DetalleCotizacion::findOrFail($detalle['id']);
            $detalleCotizacion->update([
                'precio' => $detalle['precio'],
                'cantidad' => $detalle['cantidad'],
                'tiempo_entrega' => $detalle['tiempo_entrega'],
            ]);
        }

        return redirect()->back()->with('success', 'Cotización actualizada correctamente.');
    }*/

}
