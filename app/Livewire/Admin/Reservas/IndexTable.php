<?php

namespace App\Livewire\Admin\Reservas;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Reserva;

class IndexTable extends DataTableComponent
{
    protected $model = Reserva::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Pre venta id", "pre_venta_id")
                ->sortable(),
            Column::make("User id", "user_id")
                ->sortable(),
            Column::make("Cantidad", "cantidad")
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
