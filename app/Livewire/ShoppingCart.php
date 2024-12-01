<?php

namespace App\Livewire;

use CodersFree\Shoppingcart\Facades\Cart;
use Livewire\Attributes\Computed;
use Livewire\Component;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class ShoppingCart extends Component
{
    public $preferenceId;

    //sobre que instancia de cart estamos trabajando
    public function mount()
    {
        Cart::instance('shopping');
        $this->createPreference(); // Llama a createPreference al montar el componente
    }

    #[Computed()]
    public function subtotal()
    {
        return Cart::content()->filter (function ($item){
            return $item->qty <= $item->options['stock'];
        })
            ->sum(function ($item){
                return $item->subtotal;
            });
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



    public function createPreference()
{
    // Inicializa el SDK de MercadoPago
    MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

    Cart::instance('shopping');
    // Obtiene los productos del carrito
    $cartItems = Cart::content();

    // Si el carrito está vacío
    if ($cartItems->isEmpty()) {
        return;
    }

    // Construye el array de items en el formato correcto
    $items = [];
    foreach ($cartItems as $item) {
        $items[] = [
            "id" => $item->rowId,                   // Asignar el rowId cdel carrito como ID unico
            "title" => $item->name,               // Nombre del producto
            "quantity" => (int)$item->qty,       // Cantidad (entero)
            "unit_price" => (float)$item->price,  // Precio unitario (flotante)
            "currency_id" => "ARS"  ,             // Moneda (ISO 4217)
            "picture_url" => $item->options['image'] // URL de la imagen
        ];
    }

    // Crea un cliente de preferencias
    $client = new PreferenceClient();

    try {
        $preference = $client->create([
            "items" => $items,
            "back_urls" => [
                "success" => route('payment.success'),
                "failure" => route('payment.failure'),
                "pending" => route('payment.pending')
            ],
            "auto_return" => "approved",
            "statement_descriptor" => "Elisa Modas",
            "external_reference" =>
                auth()->check() ? auth()->id() : session()->getId(),
        ]);


        // Redirige al usuario al link de pago
        //return redirect()->to($preference->init_point);  // Redirigir a la URL de MercadoPago

        $this->preferenceId = $preference->id; // Establece el ID de la preferencia
        //$preference->save();

        //mostrar los detalles de la preferencia
        //dd($preference);


    } catch (\MercadoPago\Exceptions\MPApiException $e) {
        dd($e->getMessage(), $e->getCode());
    }
}




    public function render()
    {
        return view('livewire.shopping-cart');
    }
}
