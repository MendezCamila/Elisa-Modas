<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Illuminate\Http\Request;
use MercadoPago\Preference;
use MercadoPago\Item;
use CodersFree\Shoppingcart\Facades\Cart;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Payment;
use MercadoPago\Client\Preference\PreferenceClient;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use MercadoPago\Exceptions\MPApiException;



class PaymentController extends Controller
{

    public function success(Request $request)
{
    $accessToken = config('services.mercadopago.access_token');
    $paymentId = $request->input('payment_id');

    try {
        $client = new Client();
        $response = $client->request('GET', "https://api.mercadopago.com/v1/payments/{$paymentId}", [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
            ],
        ]);

        $payment = json_decode($response->getBody()->getContents());

        if ($payment->status == 'approved') {
            // Aquí puedes realizar acciones como actualizar la base de datos, notificar al usuario, etc.
            // Redirigir a una vista de éxito o una página personalizada
            //dd('Pago aprobado', $payment);


            $idCart = $payment->external_reference;


            //obtener la instancia del carrito con el idCart
            Cart::instance('shopping');

            //imprimir el contenido del carrito
            //dd(Cart::content());

            //Crear instancia de  tabla venta
            Ventas::create([
                'user_id' => auth()->id(),
                'content' => Cart::content(),
                'payment_id' => $payment->id,
                'total' => floatval(str_replace(',', '', Cart::subtotal())), // Convertimos a número flotante
            ]);

            //crear una instancia de la tabla Itemventa, recorrer el contenido del carrito y guardar cada item en la tabla Itemventa

            //vaciar el carrito
            Cart::destroy();
            return view('payment.success', compact('payment'));
        }

        return 'Pago rechazado';
    } catch (RequestException $e) {
        // Maneja la excepción y muestra el mensaje de error
        $response = $e->getResponse();
        $responseBodyAsString = $response ? $response->getBody()->getContents() : 'No response body';
        return response()->json([
            'error' => 'Error al obtener el pago de MercadoPago',
            'message' => $responseBodyAsString,
        ], 500);
    } catch (MPApiException $e) {
        // Maneja la excepción específica de MercadoPago
        return response()->json([
            'error' => 'Error de API de MercadoPago',
            'message' => $e->getMessage(),
        ], 500);
    } catch (\Exception $e) {
        // Maneja cualquier otra excepción
        return response()->json([
            'error' => 'Error inesperado',
            'message' => $e->getMessage(),
        ], 500);
    }
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
