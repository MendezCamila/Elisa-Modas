<?php

namespace App\Livewire\Admin\OrdenCompra;

use Livewire\Component;
use App\Models\Cotizacion;
use App\Models\Supplier;
use App\Models\Variant;
use App\Models\OrdenCompra;
use App\Models\DetalleOrdenCompra;


class CreateOrdenCompra extends Component
{
    public $cotizacion;
    public $detalles = [];

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
        return view('livewire.admin.orden-compra.create-orden-compra');
    }
}
