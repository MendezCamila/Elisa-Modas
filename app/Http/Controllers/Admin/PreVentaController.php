<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PreVenta;
use App\Jobs\NotificarReservantesJob;

class PreVentaController extends Controller
{
    public function index()
    {
        return view('admin.pre-ventas.index');
    }

    public function create()
    {
        return view('admin.pre-ventas.create');
    }

    // Muestra la vista con los datos de la preventa y el formulario para registrar la recepción
    public function showReceptionForm(PreVenta $preVenta)
    {
        return view('admin.pre-ventas.reception', compact('preVenta'));
    }

    // Procesa el registro de la recepción
    public function registerReception(Request $request, PreVenta $preVenta)
    {

        // Validar el campo cantidadRecibida
        $request->validate([
            'cantidadRecibida' => 'required|integer|min:1',
        ]);

        // Accedemos a la variante relacionada a la preventa
        $variant = $preVenta->variant;

        if ($variant) {
            // Incrementa el stock de la variante
            $variant->increment('stock', $request->cantidadRecibida);

            // Si la variante no está disponible, la actualizamos a 'disponible'
            if ($variant->estado !== 'disponible') {
                $variant->update(['estado' => 'disponible']);
            }
        }

        // Actualizamos el estado de la preventa
        $preVenta->update(['estado' => 'disponible']);

        // **Llamar al Job para enviar notificaciones a los clientes reservantes**
        NotificarReservantesJob::dispatch($preVenta->id);

        // Redirigimos a la lista de preventas con un mensaje de éxito
        return redirect()->route('admin.pre-ventas.index')
            ->with('success', 'Recepción registrada correctamente.');
    }
}
