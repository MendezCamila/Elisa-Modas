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

        $ordenesCompra = OrdenCompra::with(['detalleOrdenCompras.variant.product', 'proveedor'])
            ->when($request->input('supplier_id'), function ($query, $supplierId) {
                return $query->where('supplier_id', $supplierId);
            })
            ->when($request->input('date_range'), function ($query, $dateRange) {
                $dates = explode(' - ', $dateRange);
                $query->whereBetween('created_at', [$dates[0], $dates[1]]);
            })
            ->get();

        $pdf = Pdf::loadView('admin.orden-compras.pdf', compact('ordenesCompra'));
        return $pdf->download('orden-compra.pdf');
    }
}
