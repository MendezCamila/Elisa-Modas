<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use MercadoPago\Preference;
use MercadoPago\Item;
use CodersFree\Shoppingcart\Facades\Cart;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;


class PaymentController extends Controller
{

    public function createPreference()
{
    // Inicializa el SDK de MercadoPago
    MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

    Cart::instance('shopping');
    // Obtiene los productos del carrito
    $cartItems = Cart::content();

    // Depuración
    if ($cartItems->isEmpty()) {
        dd($cartItems); // Muestra el contenido del carrito si está vacío
        throw new \Exception('El carrito está vacío.');
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
            "statement_descriptor" => "Elisa Modas",
            "back_urls" => [
                "success" => route('payment.success'),
                "failure" => route('payment.failure'),
                "pending" => route('payment.pending')
            ],
            "auto_return" => "approved",
        ]);

        // Redirige al usuario al link de pago
        //return redirect()->to($preference->init_point);  // Redirigir a la URL de MercadoPago

        $preference->save();

        //Pasa el id de la preferencia a la vista
        //return view('livewire.shopping-cart', compact('preference'));
        return redirect()->route('livewire.shopping-cart', ['preferenceId' => $preference->id]);

    } catch (\MercadoPago\Exceptions\MPApiException $e) {
        dd($e->getMessage(), $e->getCode());
    }
}




    public function success()
    {
        return 'Pago aprobado';
    }

    public function failure()
    {
        return 'Pago rechazado';
    }

    public function pending()
    {
        return 'Pago pendiente';
    }
}
