<?php

namespace App\Livewire\Admin\OrdenCompra;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\OrdenCompra;

class IndexTable extends DataTableComponent
{
    protected $model = OrdenCompra::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Estado", "estado")
                ->sortable(),
            Column::make("Supplier id", "supplier_id")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
        ];
    }
}
