<?php

namespace App\Livewire\Products;

use Livewire\Component;

class AddToCart extends Component
{
    //recibimos el producto de la vist
    public $product;
    public $quantity = 1;

    public function render()
    {
        return view('livewire.products.add-to-cart');
    }
}
