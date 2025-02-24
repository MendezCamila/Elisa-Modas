<?php

namespace App\Livewire\Admin\Cotizaciones;

use Livewire\Component;
use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Models\Supplier;

class ShowCotizacion extends Component
{

    public $cotizacion; //Cotizacion cargada
    public $proveedor; //Proveedor de la cotizacion
    public $detalles;
    public $tiempo_entrega; // Tiempo de entrega ingresado por el proveedor
    public $detalleCotizaciones = []; //datos dinamicos que completara el proveedor

    public function mount($id)
    {

        $this->cotizacion = Cotizacion::with('detalleCotizaciones.variant', 'proveedor')->findOrFail($id);

        // Cargar manualmente el proveedor si la relación no está cargada
        if (is_null($this->cotizacion->proveedor)) {
            $this->proveedor = Supplier::find($this->cotizacion->supplier_id);
        } else {
            $this->proveedor = $this->cotizacion->proveedor;
        }

        //dd($this->proveedor);

        //preparar los detalles para que el proveedor los complete
        foreach ($this->cotizacion->detalleCotizaciones as $detalle) {
            $this->detalleCotizaciones[$detalle->id] = [
                'precio' => null,
                'cantidad' => null,
                'disponible' => $detalle->disponible,
            ];
        }
    }

    public function guardarCotizacion()
{
    $this->validate([
        'tiempo_entrega' => 'required|numeric|min:1',
    ]);

    foreach ($this->detalleCotizaciones as $detalleId => $valores) {
        // Si el proveedor no ingresó precio o cantidad, el producto se considera "No disponible"
        if (empty($valores['precio']) || empty($valores['cantidad'])) {
            $valores['precio'] = null;
            $valores['cantidad'] = null;
        } else {
            // Validar precio y cantidad si el proveedor sí ingresó valores
            if (!is_numeric($valores['precio']) || $valores['precio'] < 1) {
                $this->addError("detalleCotizaciones.$detalleId.precio", 'El campo precio debe ser numérico y mayor a 0.');
            }
            if (!is_numeric($valores['cantidad']) || $valores['cantidad'] < 1) {
                $this->addError("detalleCotizaciones.$detalleId.cantidad", 'El campo cantidad debe ser numérico y mayor a 0.');
            }
        }
    }

    if ($this->getErrorBag()->isNotEmpty()) {
        return; // Detener la ejecución si hay errores de validación
    }

    // Guardar los detalles de la cotización
    foreach ($this->detalleCotizaciones as $detalleId => $valores) {
        $detalle = DetalleCotizacion::findOrFail($detalleId);

        $detalle->update([
            'precio' => $valores['precio'],
            'cantidad' => $valores['cantidad'],
            'tiempo_entrega' => $this->tiempo_entrega,
            'disponible' => !is_null($valores['precio']) && !is_null($valores['cantidad']) ? 1 : 0, // Si precio y cantidad son null, "No disponible"
        ]);
    }

    $this->cotizacion->update(['estado' => 'respondida']);

    session()->flash('swal', [
        'icon' => 'success',
        'title' => '¡Bien hecho!',
        'text' => 'La cotización ha sido enviada correctamente',
    ]);
}

    public function actualizarDisponibilidad($detalleId)
    {
        if (!$this->detalleCotizaciones[$detalleId]['disponible']) {
            $this->detalleCotizaciones[$detalleId]['precio'] = null;
            $this->detalleCotizaciones[$detalleId]['cantidad'] = null;
        }
    }


    public function render()
    {
        return view('livewire.admin.cotizaciones.show-cotizacion', [
            'cotizacion' => $this->cotizacion,
            'proveedor' => $this->proveedor,
        ]);
    }
}
