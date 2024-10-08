<?php

namespace App\Livewire\Products;

use App\Models\Feature;
use Livewire\Attributes\Computed;
use Livewire\Component;
use CodersFree\Shoppingcart\Facades\Cart;

class AddToCartVariants extends Component
{
    //recibimos el producto de la vist
    public $product;
    public $qty = 1;
    public $selectedFeatures = [];

    public function mount()
    {
        $this->selectedFeatures = $this->product->variants->first()->features->pluck('id', 'option_id')->ToArray();
    }

    #[Computed]
    public function variant()
    {
        //que nos retorne las variantes del producto
        return $this->product->variants->filter(function($variant){
            return !array_diff($variant->features->pluck('id')->toArray(), $this->selectedFeatures);
        })->first();
    }

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
                'sku' => $this->variant->sku,
                'features' => Feature::whereIn('id', $this->selectedFeatures)
                    ->pluck('description', 'id')
                    ->toArray(),
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
        return view('livewire.products.add-to-cart-variants');
    }
}
