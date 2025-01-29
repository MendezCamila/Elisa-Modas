<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrdenCompra;
use Barryvdh\DomPDF\Facade\Pdf;


class PdfExportController extends Controller
{
    /*public function exportOrdenesCompra(Request $request)
    {
        \Log::debug('Filtros recibidos: ', $request->input('table-filters'));

    $ordenesCompra = OrdenCompra::with(['detalleOrdenCompras.variant.product', 'proveedor'])
        ->when($request->input('table-filters.supplier_id'), function ($query, $supplierId) {
            return $query->where('supplier_id', $supplierId);
        })
        ->when($request->input('table-filters.rango_de_fechas.minDate') && $request->input('table-filters.rango_de_fechas.maxDate'), function ($query) use ($request) {
            $minDate = $request->input('table-filters.rango_de_fechas.minDate');
            $maxDate = $request->input('table-filters.rango_de_fechas.maxDate');
            return $query->whereBetween('created_at', [$minDate, $maxDate]);
        })
        ->get();

    $pdf = Pdf::loadView('admin.orden-compras.pdf', compact('ordenesCompra'));
    return $pdf->download('orden-compra.pdf');
    }*/

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

        $pdf = Pdf::loadView('admin.orden-compras.pdf', compact('ordenesCompra'));
        return $pdf->download('orden-compra.pdf');
    }

}
