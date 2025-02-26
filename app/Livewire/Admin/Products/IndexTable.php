<?php

namespace App\Livewire\Admin\Products;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\Views\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Subcategory;

class IndexTable extends DataTableComponent
{
    protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTableAttributes([
            'class' => 'table table-striped table-bordered',
        ]);
        // Ordenar por fecha de creación en orden descendente
        // Desambiguar la columna "created_at" usando "products.created_at"
        $this->setDefaultSort('products.created_at', 'desc');

        $this->setPaginationEnabled(); // Habilitar paginación
        $this->setSortingPillsEnabled(); // Habilitar ordenamiento
        $this->setSearchVisibilityStatus(true);
        $this->setSearchVisibilityEnabled();
        $this->setSearchEnabled();  // Habilita la búsqueda
        $this->setSearchPlaceholder('Buscar');  // Cambia el placeholder
        $this->setEmptyMessage('No se encontraron resultados'); // Mensaje de tabla vacía

    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->searchable(),
            Column::make("SKU", "sku")
                ->searchable(),
            Column::make("Nombre", "name")
                ->searchable(),
                Column::make("Precio", "price")
                ->format(fn($value) => "$" . number_format($value, 2)),

            Column::make("Acciones")
                ->label(function ($row) {
                    return '<a href="' . route('admin.products.edit', $row) . '" class="text-blue-600 hover:underline">Ver</a>';
                })
                ->html(),
        ];
    }


    public function query()
    {
        return Product::query()
            ->with('subcategory')
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('id', 'like', "%{$this->search}%")
                      ->orWhere('name', 'like', "%{$this->search}%")
                      ->orWhere('sku', 'like', "%{$this->search}%");
                });
            });
    }
}
