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
        // Ordenar por fecha de creación en orden descendente
        $this->setDefaultSort('created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            //Nº venta
            Column::make("Nº venta", "id")
                ->sortable(),

            //Fecha de venta
            Column::make("F. venta", "created_at")
                ->format(function($value){
                    return $value->format('d/m/Y');
                })
                ->sortable(),

            //Usuario que realizó la compra
            Column::make("id cliente", "user_id")
                ->sortable(),

             // Columna "User ID" que muestra el nombre del usuario
            Column::make("Cliente", "user.name")
                ->label(function($row){
                return $row->user ? $row->user->name . ' ' . $row->user->last_name : 'No asignado';
            })
            ->sortable(),

            //Nº de operación (payment_id)
            Column::make("Nº de operación", "payment_id")
                ->sortable(),

            //Total de la venta
            Column::make("Total", "total")
                ->format(function($value){
                    return "$".number_format($value, 2);
                })
                ->sortable(),

            /*
            Column::make("Cantidad", "content")
                ->format(function($value){
                    return count($value);
                })
                ->sortable(),*/

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
