<?php

namespace App\Livewire\Admin\Cotizaciones;

use Livewire\Component;
use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Models\Variant;
use App\Models\Supplier;


class ShowAdminCotizacion extends Component
{
    public $cotizacion;

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



        //dd($this->cotizacion);

    }

    public function render()
    {
        return view('livewire.admin.cotizaciones.show-admin-cotizacion');
    }
}
