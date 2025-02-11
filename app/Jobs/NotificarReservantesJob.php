<?php

namespace App\Jobs;

use App\Mail\ProductAvailableMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Reserva;
use App\Models\User;
use App\Models\PreVenta;
use Illuminate\Support\Facades\Mail;

class NotificarReservantesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $preVentaId;

    /**
     * Create a new job instance.
     */
    public function __construct($preVentaId)
    {
        $this->preVentaId = $preVentaId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //Obtener todas las reservas de la preventa que cambio a disponible
        $reservas = Reserva::where('pre_venta_id', $this->preVentaId)->get();

        foreach ($reservas as $reserva) {
            if ($reserva->user) {
                // Enviar correo electrónico al usuario que reservó
                Mail::to($reserva->user->email)->send(new ProductAvailableMail($reserva));
            }
        }
    }
}
