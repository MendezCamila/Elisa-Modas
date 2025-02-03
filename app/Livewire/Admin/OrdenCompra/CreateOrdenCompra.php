<?php

namespace App\Livewire\Admin\OrdenCompra;

use Livewire\Component;
use App\Models\Cotizacion;
use App\Models\Supplier;
use App\Models\Variant;
use App\Models\OrdenCompra;
use App\Models\DetalleOrdenCompra;
use App\Mail\EnviarOrdenCompraMail;
use Illuminate\Support\Facades\Mail;


class CreateOrdenCompra extends Component
{
    public $cotizacion;
    public $detalles = [];
    public $proveedor;

    public function mount($cotizacionId)
    {

        // Carga la cotización con todas las relaciones necesarias
        $this->cotizacion = Cotizacion::with(['detalleCotizaciones.variant', 'detalleCotizaciones.variant.product'])->findOrFail($cotizacionId);

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

    public function boot()
    {
        $this->withValidator(function ($validator) {
            // Verificar si hay errores de validación
            if ($validator->fails()) {
                // Disparar una alerta con los detalles del error
                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => 'Error!',
                    'text' => 'El formulario contiene errores.',
                ]);
            }
        });
    }

    public function removeProducto($index)
{
    if (count($this->detalles) > 1) {
        // Eliminar el producto de la lista
        unset($this->detalles[$index]);

        // Reindexar el array para mantener las claves ordenadas
        $this->detalles = array_values($this->detalles);
    } else {
        session()->flash('error', 'Debe haber al menos un producto en la orden de compra.');
    }
}



    public function submit()
    {

        $this->validate([
            'detalles' => 'required|array|min:1',
            'detalles.*.variant_id' => 'required|exists:variants,id',
            'detalles.*.cantidad_solicitada' => 'required|integer|min:1',
        ], [
            'detalles.required' => 'Debe agregar al menos un producto a la orden de compra.',
            'detalles.*.variant_id.required' => 'El producto seleccionado no es válido.',
            'detalles.*.variant_id.exists' => 'El producto seleccionado no existe.',
            'detalles.*.cantidad_solicitada.required' => 'Debe ingresar la cantidad solicitada para cada producto.',
            'detalles.*.cantidad_solicitada.integer' => 'La cantidad solicitada debe ser un número entero.',
            'detalles.*.cantidad_solicitada.min' => 'La cantidad solicitada debe ser al menos 1.',
        ]);

        // Crear la orden de compra
        $ordenCompra = OrdenCompra::create([
            'estado' => 'pendiente',
            'supplier_id' => $this->cotizacion->supplier_id,
        ]);

        foreach ($this->detalles as $detalle) {
            if (!is_null($detalle['precio'])) {
                DetalleOrdenCompra::create([
                    'cantidad' => $detalle['cantidad_solicitada'],
                    'precio_unitario' => $detalle['precio'],
                    'total' => $detalle['cantidad_solicitada'] * $detalle['precio'],
                    'orden_compra_id' => $ordenCompra->id,
                    'variant_id' => $detalle['variant_id'],
                ]);
            }
        }

        // Cargar las relaciones necesarias para el correo
        $ordenCompra->load(['detalleOrdenCompras.variant.product', 'proveedor']);

        //dd($ordenCompra->toArray());


        // Enviar el correo
        Mail::to($this->proveedor->email)->send(new EnviarOrdenCompraMail($ordenCompra));




        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Bien hecho!',
            'text' => 'La orden de compra ha sido enviada correctamente',
        ]);

        return redirect()->route('admin.orden-compras.index');
    }

    public function render()
    {
        return view('livewire.admin.orden-compra.create-orden-compra');
    }
}
