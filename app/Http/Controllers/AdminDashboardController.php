<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $ventasxsubcategoria = DB::table('ventas')->get();

        $estadisticas=[];

        foreach ($ventasxsubcategoria as $venta){
            $content = json_decode($venta->content, true); //decodificamos el json

            foreach ($content as $item) {
                $productId = $item['id']; // Obtén el ID del producto desde el JSON
                $cantidad = $item['qty']; // Obtén la cantidad vendida

                // Obtén la subcategoría del producto
                $subcategoria = DB::table('products')
                    ->join('subcategories', 'subcategories.id', '=', 'products.subcategory_id')
                    ->where('products.id', $productId)
                    ->value('subcategories.name');

                // Suma las cantidades vendidas por subcategoría
                if (isset($estadisticas[$subcategoria])) {
                    $estadisticas[$subcategoria] += $cantidad;
                } else {
                    $estadisticas[$subcategoria] = $cantidad;
                }
            }
        }

        arsort($estadisticas); // Ordena el array de mayor a menor

        //formatea para la vista
        $data = collect($estadisticas)->map(function ($cantidad, $subcategoria) {
            return ['subcategory' => $subcategoria, 'total' => $cantidad];
        })->values();

        dd($data);

        return view('admin.dashboard', [
            'ventas' => $ventasData,
            'promedioVentas' => $promedioVentas,
            'unidadesVendidas' =>$data,
        ]);
    }
}
