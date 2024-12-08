<?php

namespace App\Http\Controllers;
use App\Models\Ventas;
use Carbon\Carbon;

use Illuminate\Http\Request;


class AdminDashboardController extends Controller
{
    public function index()
    {

        // Obtener las ventas del mes actual, agrupadas por día
        $ventas = Ventas::whereMonth('created_at', Carbon::now()->month)
            ->selectRaw('DAY(created_at) as day, sum(total) as total')
            ->groupByRaw('DAY(created_at)')
            ->orderByRaw('DAY(created_at)')
            ->get();
        //dd($ventas)->toArray() ;

        return view('admin.dashboard', [
            'ventas' => $ventas
        ]);
    }
}
