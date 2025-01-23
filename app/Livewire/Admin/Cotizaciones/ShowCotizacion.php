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


    }

    public function render()
    {
        return view('livewire.admin.cotizaciones.show-cotizacion', [
            'cotizacion' => $this->cotizacion,
            'proveedor' => $this->proveedor,
        ]);
    }
}
