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

    public function mount()
    {
        // Selecciona la primera variante del producto (puedes ajustar esta lógica si es necesario)
        $this->variant = $this->product->variants->first();
        // Solo mostramos las features de la variante seleccionada
        $this->selectedFeatures = $this->variant->features->pluck('id', 'option_id')->toArray();

        // Buscar la preventa usando el id de la variante, no del producto
        $preVenta = PreVenta::where('variant_id', $this->variant->id)
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

        // Si existe una preventa activa para esta variante, usamos su datos
        if ($preVenta = PreVenta::where('variant_id', $this->variant->id)->where('estado', 'activo')->first()) {
            $this->preventaDescuento = $preVenta->descuento;
            $this->stock = $preVenta->cantidad;
        } else {
            $this->stock = $this->variant->stock;
        }
        $this->qty = 1;
    }

    public function getDiscountedPriceProperty()
    {
        // Aplica el descuento sobre el precio original del producto
        return $this->product->price * (1 - $this->preventaDescuento / 100);
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
