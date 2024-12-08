<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Carbon\Carbon;

use Illuminate\Http\Request;


class AdminDashboardController extends Controller
{
    public function index()
    {



        //Obtenemos las ventas mensuales y calculamos el promedio de ventas por mes
        $ventas = Ventas::selectRaw('MONTH(created_at) as month, sum(total) as total')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();

        //calculamos el total de ventas y el numero de meses
        $totalVentas = $ventas->sum('total');
        $numMeses = $ventas->count();

        //calculamos el promedio de ventas por mes
        $promedioVentas = $numMeses > 0 ? $totalVentas / $numMeses : 0;

        // Pasamos los datos al gráfico, calculando el promedio por mes
        $ventasData = $ventas->map(function ($venta) use ($promedioVentas) {
            return [
                'month' => $venta->month,
                'total' => $venta->total,
                'average' => $promedioVentas, // Añadimos el promedio a los datos
            ];
        })->toArray();

        //dd($ventasData);

        return view('admin.dashboard', [
            'ventas' => $ventasData,
            'promedioVentas' => $promedioVentas,
        ]);
    }
}
