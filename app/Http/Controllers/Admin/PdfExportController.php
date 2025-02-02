<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrdenCompra;
use App\Models\Ventas;
use Barryvdh\DomPDF\Facade\Pdf;


class PdfExportController extends Controller
{
    public function exportOrdenesCompra(Request $request)
    {
        $filters = $request->input('table-filters');
        //dd($filters); // Debugging line




        $ordenesCompra = OrdenCompra::with(['detalleOrdenCompras.variant.product', 'proveedor'])
            ->when(isset($filters['supplier_id']), function ($query) use ($filters) {
                return $query->where('supplier_id', $filters['supplier_id']);
            })
            ->when(isset($filters['rango_de_fechas']['minDate']) && isset($filters['rango_de_fechas']['maxDate']), function ($query) use ($filters) {
                $minDate = $filters['rango_de_fechas']['minDate'];
                $maxDate = $filters['rango_de_fechas']['maxDate'];
                return $query->whereBetween('created_at', [$minDate, $maxDate]);
            })
            ->get();

        $pdf = Pdf::loadView('admin.orden-compras.pdf', compact('ordenesCompra', 'filters'));
        return $pdf->download('orden-compra.pdf');
    }

    public function exportVentas(Request $request)
    {
        $filters = $request->input('table-filters');
    // dd($filters); // Debugging line

    $ventas = Ventas::with(['user'])
        // Filtrar por ID de usuario si está presente
        ->when(isset($filters['user_id']), function ($query) use ($filters) {
            return $query->where('user_id', $filters['user_id']);
        })
        // Filtrar por rango de fechas si están presentes
        ->when(isset($filters['rango_de_fechas']['minDate']) && isset($filters['rango_de_fechas']['maxDate']), function ($query) use ($filters) {
            $minDate = $filters['rango_de_fechas']['minDate'];
            $maxDate = $filters['rango_de_fechas']['maxDate'];
            return $query->whereBetween('created_at', [$minDate, $maxDate]);
        })
        // Filtrar por rango de precio si está presente
        ->when(isset($filters['rango_de_precio']['min']) && isset($filters['rango_de_precio']['max']), function ($query) use ($filters) {
            $minPrice = $filters['rango_de_precio']['min'];
            $maxPrice = $filters['rango_de_precio']['max'];
            return $query->whereBetween('total', [$minPrice, $maxPrice]);
        })
        // Filtrar por estado si está presente
        ->when(isset($filters['estado']), function ($query) use ($filters) {
            return $query->where('estado', $filters['estado']);
        })
        ->get();

        $pdf = Pdf::loadView('admin.ventas.informepdf', compact('ventas', 'filters'));
        return $pdf->download('ventas.pdf');
    }
}
