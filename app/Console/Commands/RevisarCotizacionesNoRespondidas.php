<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cotizacion;
use Carbon\Carbon;

class RevisarCotizacionesNoRespondidas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cotizaciones:revisar-no-respondidas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar el estado de las cotizaciones a "no respondida" si todos sus detalles vencieron sin respuesta';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoy = Carbon::now();

        // Buscar cotizaciones en estado "enviada"
        $cotizaciones = Cotizacion::where('estado', 'enviada')->get();

        $contador = 0; // Para contar las cotizaciones actualizadas

        foreach ($cotizaciones as $cotizacion) {
            // Verificar si TODOS los detalles de la cotización están vencidos y no tienen respuesta
            $detallesPendientes = $cotizacion->detalleCotizaciones()
                ->where('plazo_resp', '<', $hoy) // Plazo vencido
                ->whereNull('precio') // Sin respuesta de precio
                ->whereNull('cantidad') // Sin respuesta de cantidad
                ->count();

            if ($detallesPendientes === $cotizacion->detalleCotizaciones()->count()) {
                // Si todos los detalles están pendientes y vencidos, actualizar estado
                $cotizacion->update(['estado' => 'no respondida']);
                $contador++;
            }
        }

        $this->info("Se actualizaron {$contador} cotizaciones a estado 'no respondida'.");
    }
}
