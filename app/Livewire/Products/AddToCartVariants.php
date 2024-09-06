<?php

namespace App\Livewire\Products;

use Livewire\Component;

class AddToCartVariants extends Component
{
    //recibimos el producto de la vist
    public $product;
    public $qty = 1;
    public $selectedFeatures = [];

    public function mount()
    {
        //inicializamos las opciones seleccionadas
        foreach ($this->product->options as $option) {
            $features = collect($option->pivot->features);

            $this->selectedFeatures[$option->id] = $features->first()['id'];

        }


    }

    public function render()
    {
        return view('livewire.products.add-to-cart-variants');
    }
}
