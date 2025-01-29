<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrdenCompra;
use Barryvdh\DomPDF\Facade\Pdf;


class PdfExportController extends Controller
{
    public function exportOrdenesCompra(Request $request)
    {
        // Obtener los filtros de la URL
        $ordenesCompra = OrdenCompra::with(['detalleOrdenCompras.variant.product', 'proveedor'])
            // Filtro por proveedor
            ->when($request->input('table-filters.supplier_id'), function ($query, $supplierId) {
                return $query->where('supplier_id', $supplierId);
            })
            // Filtro por rango de fechas
            ->when($request->input('table-filters.rango_de_fechas.minDate') && $request->input('table-filters.rango_de_fechas.maxDate'), function ($query) use ($request) {
                $minDate = $request->input('table-filters.rango_de_fechas.minDate');
                $maxDate = $request->input('table-filters.rango_de_fechas.maxDate');
                return $query->whereBetween('created_at', [$minDate, $maxDate]);
            })
            ->get();

        // Cargar la vista PDF con los datos filtrados
        $pdf = Pdf::loadView('admin.orden-compras.pdf', compact('ordenesCompra'));
        return $pdf->download('orden-compra.pdf');
    }
}
