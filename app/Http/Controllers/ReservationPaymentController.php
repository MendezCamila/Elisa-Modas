<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use MercadoPago\Exceptions\MPApiException;

class ReservationPaymentController extends Controller
{


    public function onlinePayment($id)
    {
        //recuperamos la reserva
        $reserva = Reserva::findOrFail($id);

        // Configurar Mercado Pago SDK
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

        // Construye el item para la preferencia de pago usando los datos de la reserva
        $item = [
            "id"           => $reserva->id,
            "title"        => $reserva->preventa->variant->product->name,    // Se accede al producto mediante preVenta y variant
            "quantity"     => (int) $reserva->cantidad,
            "unit_price"   => round((float)$reserva->preventa->variant->product->price * (1 - $reserva->preventa->descuento / 100), 2),
            "currency_id"  => "ARS",
            // "picture_url" => $reserva->preVenta->variant->product->image_path, // Opcional: si tienes la imagen
        ];

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
            return redirect()->to($preference->init_point); // Redirigir a la URL de Mercado Pago




        } catch (MPApiException $e) {
            // En caso de error en la API de Mercado Pago, se muestra el error
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
        $accessToken = config('services.mercadopago.access_token');
        $paymentId = $request->input('payment_id');

        try {
            $client = new GuzzleClient();
            $response = $client->request('GET', "https://api.mercadopago.com/v1/payments/{$paymentId}", [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                ],
            ]);

            $payment = json_decode($response->getBody()->getContents());

            if ($payment->status == 'approved') {
                // Recupera la reserva utilizando el ID pasado en la URL (external_reference)
                $reserva = Reserva::findOrFail($id);
                // Actualiza el estado de la reserva a "pagada"
                $reserva->update(['estado' => 'pagada']);

                // Descuenta el stock de la variante asociada a la preventa
                if ($reserva->preVenta && $reserva->preVenta->variant) {
                    $reserva->preVenta->variant->decrement('stock', $reserva->cantidad);
                }

                return view('reservations.payment-success', compact('payment', 'reserva'));
            }

            return 'Pago rechazado';
        } catch (RequestException $e) {
            $response = $e->getResponse();
            $body = $response ? $response->getBody()->getContents() : 'No response body';
            return response()->json([
                'error' => 'Error al obtener el pago de MercadoPago',
                'message' => $body,
            ], 500);
        } catch (MPApiException $e) {
            return response()->json([
                'error' => 'Error de API de MercadoPago',
                'message' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error inesperado',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
