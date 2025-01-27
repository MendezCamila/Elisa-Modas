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
    public $proveedor;

    public function mount($cotizacionId)
    {

        // Carga la cotización con todas las relaciones necesarias
        $this->cotizacion = Cotizacion::with(['detalleCotizaciones.variant.features', 'detalleCotizaciones.variant.product'])->findOrFail($cotizacionId);

        // Cargar manualmente el proveedor si la relación no está cargada
        if (is_null($this->cotizacion->proveedor)) {
            $this->proveedor = Supplier::find($this->cotizacion->supplier_id);
        } else {
            $this->proveedor = $this->cotizacion->proveedor;
        }

        // Cargar los detalles de la cotización
        foreach ($this->cotizacion->detalleCotizaciones as $detalle) {
            $this->detalles[] = [
                'variant_id' => $detalle->variant_id,
                'cantidad_ofrecida' => $detalle->cantidad,
                'precio' => $detalle->precio,
                'cantidad_solicitada' => $detalle->cantidad_solicitada,
            ];
        }
    }

    public function removeProducto($index)
    {
        // Eliminar el producto de la lista
        unset($this->detalles[$index]);

        // Reindexar el array para mantener las claves ordenadas
        $this->detalles = array_values($this->detalles);
    }

    public function render()
    {
        return view('livewire.admin.orden-compra.create-orden-compra');
    }
}
