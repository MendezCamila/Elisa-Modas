<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filtros de fecha
        $startDate = $request->input('start_date', Carbon::now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfYear()->format('Y-m-d'));

        // Filtro de subcategoría
        $subcategoryFilter = $request->input('subcategory');

        // Obtenemos las ventas mensuales y calculamos el promedio de ventas por mes
        $ventas = Ventas::selectRaw('MONTH(created_at) as month, sum(total) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at)')
            ->get();

        // Calculamos el total de ventas y el número de meses
        $totalVentas = $ventas->sum('total');
        $numMeses = $ventas->count();

        // Calculamos el promedio de ventas por mes
        $promedioVentas = $numMeses > 0 ? $totalVentas / $numMeses : 0;

        // Pasamos los datos al gráfico, calculando el promedio por mes
        $ventasData = $ventas->map(function ($venta) use ($promedioVentas) {
            return [
                'month' => $venta->month,
                'total' => $venta->total,
                'average' => $promedioVentas, // Añadimos el promedio a los datos
            ];
        })->toArray();

        // Obtenemos las ventas por subcategoría
        $ventasxsubcategoria = DB::table('ventas')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $estadisticas = [];

        foreach ($ventasxsubcategoria as $venta) {
            $content = json_decode($venta->content, true); // Decodificamos el JSON

            foreach ($content as $item) {
                $productId = $item['id']; // Obtén el ID del producto desde el JSON
                $cantidad = $item['qty']; // Obtén la cantidad vendida

                // Obtén la subcategoría del producto
                $subcategoria = DB::table('products')
                    ->join('subcategories', 'subcategories.id', '=', 'products.subcategory_id')
                    ->join('categories', 'categories.id', '=', 'subcategories.category_id')
                    ->join('families', 'families.id', '=', 'categories.family_id')
                    ->where('products.id', $productId)
                    ->select('subcategories.name as subcategory', 'categories.name as category', 'families.name as family')
                    ->first();

                // Verificar si la subcategoría es null
                if (!$subcategoria) {
                    continue;
                }

                // Filtrar por subcategoría si se ha seleccionado una
                if ($subcategoryFilter && $subcategoria->subcategory !== $subcategoryFilter) {
                    continue;
                }

                // Suma las cantidades vendidas por subcategoría
                $key = $subcategoria->subcategory;
                if (isset($estadisticas[$key])) {
                    $estadisticas[$key] += $cantidad;
                } else {
                    $estadisticas[$key] = $cantidad;
                }
            }
        }

        arsort($estadisticas); // Ordena el array de mayor a menor

        // Formatea para la vista
        $data = collect($estadisticas)->map(function ($cantidad, $subcategoria) {
            return ['subcategory' => $subcategoria, 'total' => $cantidad];
        })->values();

        // Obtener todas las subcategorías con sus familias y categorías para el filtro
        $subcategories = Subcategory::with('category.family')->get();

        return view('admin.dashboard', [
            'ventas' => $ventasData,
            'promedioVentas' => $promedioVentas,
            'unidadesVendidas' => $data,
            'subcategories' => $subcategories,
            'selectedSubcategory' => $subcategoryFilter,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}
