<?php

namespace App\Livewire\Products;

use CodersFree\Shoppingcart\Facades\Cart;
use Livewire\Component;

class AddToCart extends Component
{
    //recibimos el producto de la vist
    public $product;
    public $qty = 1;

    //metodo para agregar items al carrito de compras

    public function add_to_cart()
    {
        Cart::instance('shopping');

        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'options' => [
                'image' => $this->product->image,
                'sku' => $this->product->sku,
                'features' => [],
            ],
        ]);

        //solo si el usuario esta autenticado
        if (auth()->check()){
            Cart::store(auth()->id());
        }

        //emitimos el evento cartUpdated
        $this->dispatch('cartUpdated', Cart::count());



        $this->dispatch('swal', [
            'title' => 'Bien hecho!',
            'text' => 'Producto agregado al carrito de compras',
            'icon' => 'success',
        ]);
    }

    public function render()
    {
        return view('livewire.products.add-to-cart');
    }
}
