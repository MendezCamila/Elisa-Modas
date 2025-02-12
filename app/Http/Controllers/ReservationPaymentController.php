<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class ReservationPaymentController extends Controller
{
    public function onlinePayment($id)
    {
        //recuperamos la reserva
        $reserva = Reserva::findOrFail($id);

        $accessToken = config('services.mercadopago.access_token');
        $paymentId = $request->input('payment_id');

        // Construye el item para la preferencia de pago usando los datos de la reserva
        $item = [
            "id"           => $reserva->id,
            "title"        => $reserva->producto->nombre,    // Asume que la relación "producto" existe en Reserva
            "quantity"     => (int) $reserva->cantidad,
            "unit_price"   => (float) $reserva->precio_unitario, // Campo definido en la reserva
            "currency_id"  => "ARS",
            // "picture_url" => $reserva->producto->imagen_url, // Opcional: URL de la imagen del producto
        ];

        // Crea el cliente de preferencias de Mercado Pago
        $client = new PreferenceClient();

        try {
            $preference = $client->create([
                "items" => [$item],
                "back_urls" => [
                    "success" => route('reservation.paymentSuccess', $reserva->id),
                    "failure" => route('reservation.paymentFailure', $reserva->id),
                    "pending" => route('reservation.paymentPending', $reserva->id)
                ],
                "auto_return" => "approved",
                "statement_descriptor" => "Elisa Modas",
                "external_reference" => (string) $reserva->id, // Usamos el ID de la reserva como referencia externa
            ]);

            // Redirige al usuario a la URL de pago de Mercado Pago
            return redirect()->to($preference->init_point);
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            // En caso de error, devuelve una respuesta JSON con el mensaje de error
            return response()->json([
                "error" => $e->getMessage(),
                "code"  => $e->getCode()
            ], 500);
        }
    }

    public function paymentPending($id)
    {
        return view('reservations.payment-pending');
    }

    public function paymentFailure($id)
    {
        return view('reservations.payment-failure');
    }

    public function paymentSuccess(Request $request, $id)
    {
        // Aquí puedes obtener y validar los datos del pago mediante el payment_id que Mercado Pago envía
        // y actualizar el estado de la reserva, descontar el stock, etc.
        $reserva = Reserva::findOrFail($id);

        // Por ejemplo, actualizamos el estado a "pagada" (esto depende de tu lógica)
        $reserva->update(['estado' => 'pagada']);

        /* Si la reserva está asociada a una preventa y esta tiene una variante,
        // descontamos el stock de la misma.
        if ($reserva->preVenta && $reserva->preVenta->variant) {
            $reserva->preVenta->variant->decrement('stock', $reserva->cantidad);
        }*/

        return view('reservations.payment-success', compact('reserva'));
    }
}
