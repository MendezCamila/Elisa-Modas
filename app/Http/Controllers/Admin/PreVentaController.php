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

        $cantidadRecibida = $request->cantidadRecibida;

        // Obtenemos la cantidad de unidades reservadas en esta pre-venta (reservas pendientes o pagadas)
        $reservadas = $preVenta->reservas()->whereIn('estado', ['pendiente', 'pagado'])->sum('cantidad');

        // Ejemplo: Si el pool era 100, se reservaron 50 y se reciben 70,
        // entonces el stock disponible para venta normal será: 70 - 50 = 20.
        $stockDisponible = $cantidadRecibida - $reservadas;
        if ($stockDisponible < 0) {
            $stockDisponible = 0;
        }

        // Accedemos a la variante relacionada a la pre-venta
        $variant = $preVenta->variant;

        if ($variant) {
            // Primero, incrementamos el stock de la variante con la cantidad recibida
            // (Suponiendo que originalmente la variante se creó con stock 0)
            $variant->increment('stock', $cantidadRecibida);

            // Luego, actualizamos el stock restando las unidades reservadas.
            // Como la variante originalmente tenía stock 0, el stock final será igual a:
            // stockFinal = cantidadRecibida - reservadas
            $variant->update(['stock' => $stockDisponible]);

            // Actualizamos el estado de la variante:
            // Si hay stock disponible para venta normal, se marca como 'disponible'
            $variant->update(['estado' => 'disponible']);
        }

        // Actualizamos el estado de la pre-venta a 'disponible' para indicar que ya se recibió el producto
        $preVenta->update(['estado' => 'disponible']);

        /*Llamar al Job para enviar notificaciones a los clientes reservantes**/
        NotificarReservantesJob::dispatch($preVenta->id);

        session()->flash('swal', [
            'icon'  => 'success',
            'title' => 'Bien hecho!',
            'text'  => "Recepción registrada correctamente. Stock disponible para venta normal: $stockDisponible",
        ]);

        return redirect()->route('admin.pre-ventas.index');

    }
}
