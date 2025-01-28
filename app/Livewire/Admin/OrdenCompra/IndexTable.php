<?php

namespace App\Livewire\Admin\OrdenCompra;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\OrdenCompra;
use App\Models\Supplier;


class IndexTable extends DataTableComponent
{
    protected $model = OrdenCompra::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function query()
    {
        return OrdenCompra::with(['detalleOrdenCompras.variant.product', 'proveedor']);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Proveedor", "supplier_id")
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    $supplier = Supplier::find($value);
                    return $supplier ? $supplier->name . ' ' . $supplier->last_name : 'N/A';
                }),
            /*Column::make("Estado", "estado")
                ->sortable(),*/
            Column::make("Fecha de Creación", "created_at")
                ->sortable()
                ->format(function ($value) {
                    return $value->format('d/m/Y');
                }),


                /*Column::make("Acciones")
                ->label(fn () => "Acciones")
                ->format(function ($value, $column, $row) {
                    return '<a href="' . route('admin.orden-compras.showAdmin', $row->id) . '" class="text-blue-500 hover:underline">Ver detalles</a>';
                })
                ->html(),*/

                Column::make("Acciones","id")
                ->label(function ($row) {
                    return view('admin.orden-compras.actions', ['ordenCompra' => $row]);
                }),
        ];
    }
}
