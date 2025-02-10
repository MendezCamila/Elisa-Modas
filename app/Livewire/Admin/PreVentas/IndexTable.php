<?php

namespace App\Livewire\Admin\PreVentas;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PreVenta;

class IndexTable extends DataTableComponent
{
    protected $model = PreVenta::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Variant id", "variant_id")
                ->sortable(),
            Column::make("Cantidad", "cantidad")
                ->sortable(),
            Column::make("Descuento", "descuento")
                ->sortable(),
            Column::make("Fecha inicio", "fecha_inicio")
                ->sortable(),
            Column::make("Fecha fin", "fecha_fin")
                ->sortable(),
            Column::make("Estado", "estado")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
