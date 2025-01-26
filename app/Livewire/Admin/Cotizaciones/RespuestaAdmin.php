<?php

namespace App\Livewire\Admin\Cotizaciones;
use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
Use App\Models\Supplier;

use Livewire\Component;

class RespuestaAdmin extends Component
{
    public $cotizacion;
    public $proveedor;

    public function mount($cotizacionId)
    {
        // Carga la cotización con todas las relaciones necesarias
        $this->cotizacion = Cotizacion::with(['detalleCotizaciones.variant.features','detalleCotizaciones.variant.product'])->findOrFail($cotizacionId);

        // Cargar manualmente el proveedor si la relación no está cargada
        if (is_null($this->cotizacion->proveedor)) {
            $this->proveedor = Supplier::find($this->cotizacion->supplier_id);
        } else {
            $this->proveedor = $this->cotizacion->proveedor;
        }
    }



    public function render()
    {
        return view('livewire.admin.cotizaciones.respuesta-admin');
    }
}
