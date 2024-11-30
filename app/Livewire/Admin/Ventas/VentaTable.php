<?php

namespace App\Livewire\Admin\Ventas;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Ventas;
use Illuminate\Support\Facades\Storage;

class VentaTable extends DataTableComponent
{
    protected $model = Ventas::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Nº venta", "id")
                ->sortable(),
            Column::make("User id", "user_id")
                ->sortable(),
            Column::make("Payment id", "payment_id")
                ->sortable(),
            Column::make("Total", "total")
                ->format(function($value){
                    return "$".number_format($value, 2);
                })
                ->sortable(),
            Column::make("F. venta", "created_at")
                ->format(function($value){
                    return $value->format('d/m/Y');
                })
                ->sortable(),

            Column::make("Cantidad", "content")
                ->format(function($value){
                    return count($value);
                })
                ->sortable(),

            Column::make("Comprobante")
                ->label(function($row){
                    return view('admin.ventas.comprobante', ['venta' => $row]);
                })
        ];
    }

    public function descargarComprobante(Ventas $venta)
    {
        //dd($venta);
        return Storage::download($venta->pdf_path);
    }

}
