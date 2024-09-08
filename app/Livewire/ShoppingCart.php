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

    public function incrementar($rowId)
    {
        Cart::instance('shopping');
        Cart::update($rowId, Cart::get($rowId)->qty + 1);

        //solo si el usuario esta autenticado
        if (auth()->check()){
            Cart::store(auth()->id());
        }

        //emitimos el evento cartUpdated
        $this->dispatch('cartUpdated', Cart::count());
    }

    public function decrementar($rowId)
    {
        Cart::instance('shopping');
        $item = Cart::get($rowId);


        if ($item->qty == 1){
            Cart::remove($rowId);
        } else {
            Cart::update($rowId, $item->qty - 1);
        }

        //solo si el usuario esta autenticado
        if (auth()->check()){
            Cart::store(auth()->id());
        }

        //emitimos el evento cartUpdated
        $this->dispatch('cartUpdated', Cart::count());
    }

    public function quitar($rowId)
    {
        Cart::instance('shopping');
        Cart::remove($rowId);

        //solo si el usuario esta autenticado
        if (auth()->check()){
            Cart::store(auth()->id());
        }

        //emitimos el evento cartUpdated
        $this->dispatch('cartUpdated', Cart::count());
    }

    public function destroy()
    {
        Cart::instance('shopping');
        Cart::destroy();

        //solo si el usuario esta autenticado
        if (auth()->check()){
            Cart::store(auth()->id());
        }

        //emitimos el evento cartUpdated
        $this->dispatch('cartUpdated', Cart::count());
    }


    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
