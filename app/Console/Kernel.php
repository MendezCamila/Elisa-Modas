<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define las tareas programadas.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Aquí puedes programar tu comando
        $schedule->command('cotizaciones:generar')->mondays()->at('07:00');

        // Comando para revisar las cotizaciones no respondidas todos los días a la medianoche
        $schedule->command('cotizaciones:revisar-no-respondidas')->dailyAt('00:00');
    }



    /**
     * Registra los comandos disponibles.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
