<?php

namespace App\Livewire\Products;
use App\Models\PreVenta;
use App\Models\Feature;

use Livewire\Component;

class ReservarProduct extends Component
{
    public $product;
    public $variant;
    public $qty = 1;
    public $selectedFeatures = [];
    public $stock;
    public $preventaDescuento = 0;

    public function mount(){
        $this->selectedFeatures = $this->product->variants->first()->features->pluck('id', 'option_id')->toArray();
        $this->getVariant();

        // Verificar si el producto está en pre-venta
        $preVenta = PreVenta::where('variant_id', $this->product->id)
            ->where('estado', 'activo')
            ->first();

        if ($preVenta) {
            $this->preventaDescuento = $preVenta->descuento;
            $this->stock = $preVenta->cantidad;
        } else {
            $this->stock = $this->variant->stock;
        }
    }

    public function getCurrentImageProperty()
    {
        return $this->variant ? $this->variant->image : $this->product->image;
    }

    public function getCurrentStockProperty()
    {
        return $this->stock;
    }

    public function updatedSelectedFeatures($name, $value)
    {
        $this->getVariant();
    }

    public function getVariant()
    {
        $this->variant = $this->product->variants->filter(function ($variant) {
            return !array_diff($variant->features->pluck('id')->toArray(), $this->selectedFeatures);
        })->first();

        if (!$this->preventaDescuento) {
            $this->stock = $this->variant->stock;
        }
        $this->qty = 1;
    }

    public function reservar()
    {
        // Lógica para reservar
        $this->dispatch('swal', [
            'title' => 'Bien hecho!',
            'text' => 'Producto reservado correctamente',
            'icon' => 'success',
        ]);
    }



    public function render()
    {
        return view('livewire.products.reservar-product');
    }
}
