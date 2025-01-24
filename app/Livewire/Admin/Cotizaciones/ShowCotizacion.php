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
            ];
        }
    }

    public function guardarCotizacion()
    {

        //validad la entrada de datos
        $this->validate([
            'tiempo_entrega' => 'required|numeric|min:1',
            'detalleCotizaciones.*.precio' => 'required|numeric|min:1',
            'detalleCotizaciones.*.cantidad' => 'required|numeric|min:1',
        ]);

        //guardar los datos completados por el proveedor
        foreach ($this->detalleCotizaciones as $detalleId => $valores) {
            $detalle = DetalleCotizacion::findOrFail($detalleId);
            $detalle->update([
                'precio' => $valores['precio'],
                'cantidad' => $valores['cantidad'],
                'tiempo_entrega' => $this->tiempo_entrega,

            ]);
        }

        // Cambiar el estado de la cotización a "respondida"
        $this->cotizacion->update([
            'estado' => 'respondida',
        ]);

        //mostrar en un dd lo que se guardo
        //dd($this->detalleCotizaciones);
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Bien hecho!',
            'text' => 'La cotización ha sido enviada correctamente',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.cotizaciones.show-cotizacion', [
            'cotizacion' => $this->cotizacion,
            'proveedor' => $this->proveedor,
        ]);
    }
}
