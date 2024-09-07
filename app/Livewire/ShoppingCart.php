<?php

namespace App\Livewire;

use CodersFree\Shoppingcart\Facades\Cart;
use Livewire\Component;

class ShoppingCart extends Component
{
    //sobre que instancia de cart estamos trabajando
    public function mount()
    {
        Cart::instance('shopping');
    }

    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
