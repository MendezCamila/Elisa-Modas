<?php

namespace App\Livewire\Products;

use App\Models\Feature;
use Livewire\Attributes\Computed;
use Livewire\Component;
use CodersFree\Shoppingcart\Facades\Cart;
use phpDocumentor\Reflection\Types\This;

class AddToCartVariants extends Component
{
    //recibimos el producto de la vist
    public $product;

    public $variant;

    public $qty = 1;
    public $selectedFeatures = [];

    public $stock;




    //Inicializamos las caracteristicas seleccionadas con las caracteristicas de la primera variante
    public function mount()
    {
        $this->selectedFeatures = $this->product->variants->first()->features->pluck('id', 'option_id')->ToArray();

        $this->getVariant();
    }

    public function updatedSelectedFeatures($name, $value)
    {
        $this->getVariant();
    }

    public function getVariant()
    {
        //que nos retorne las variantes del producto
        $this->variant = $this->product->variants->filter(function ($variant) {
            return !array_diff($variant->features->pluck('id')->toArray(), $this->selectedFeatures);
        })->first();

        $this->stock = $this->variant->stock;
        $this->qty = 1;
    }


    #[Computed]
    public function currentImage()
    {
        //imagen de la variante seleccionada o del producto general si no hay variante

        return $this->variant ? $this->variant->image : $this->product->image;
    }



    #[Computed]
    public function currentStock()
    {
        //stock de la variante seleccionada o del producto general si no hay variante
        return $this->variant ? $this->variant->stock : $this->product->stock;
    }

    public function add_to_cart()
    {
        Cart::instance('shopping');

        //existe algun producto cuyo sku sea igual al sku de la variante
        $cartItem = Cart::search(function ($cartItem, $rowId) {
            return $cartItem->options->sku === $this->variant->sku;
        })->first();

        if($cartItem){
            $stock = $this->stock - $cartItem->qty;

            if ($stock < $this->qty) {
                $this->dispatch('swal', [
                    'title' => 'Lo siento!',
                    'text' => 'No hay suficiente stock para agregar esa cantidad al carrito',
                    'icon' => 'error',
                ]);

                return;
            }
        }

        Cart::add([
            'id' => $this->product->id,
            'name' => $this->product->name,
            'qty' => $this->qty,
            'price' => $this->product->price,
            'options' => [
                'sku' => $this->variant->sku,
                'image' => $this->variant->image,
                'stock' => $this->stock,
                'sku' => $this->variant->sku,
                'features' => Feature::whereIn('id', $this->selectedFeatures)
                    ->pluck('description', 'id')
                    ->toArray(),
            ],
        ]);

        //solo si el usuario esta autenticado
        if (auth()->check()) {
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
