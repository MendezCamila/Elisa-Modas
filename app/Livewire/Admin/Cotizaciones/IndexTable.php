<?php

namespace App\Livewire\Admin\Cotizaciones;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Cotizacion;

class IndexTable extends DataTableComponent
{
    protected $model = Cotizacion::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTableAttributes([
            'class' => 'table table-striped table-bordered',
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),

            /*
            Column::make("Supplier id", "supplier_id")
                ->sortable(),

            /*
            Column::make("Orden compra id", "orden_compra_id")
                ->sortable(),*/

            Column::make("Plazo Respuesta")
                ->label(function ($row) {
                    // Accedemos a la relación detalleCotizaciones para obtener el primer plazo_resp
                    $detalle = $row->detalleCotizaciones->first();
                    return $detalle->plazo_resp ?? 'N/A';
                }),



            Column::make("Estado", "estado")
                ->sortable()
                ->searchable()
                ->html()
                ->format(fn($value) => match ($value) {
                    'pendiente' => '<span class="badge bg-warning">Pendiente</span>',
                    'enviada' => '<span class="badge bg-primary">Enviada</span>',
                    'respondida' => '<span class="badge bg-success">Respondida</span>',
                    'no respondida' => '<span class="badge bg-danger">No Respondida</span>',
                    default => '<span class="badge bg-secondary">Desconocido</span>',
                }),

            /*
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),*/

            Column::make("Acciones", "id")
            /*->format(fn($value, $row) => view('admin.cotizaciones.partials.actions', ['cotizacion' => $row])),*/
        ];
    }

    /*
    protected function formatearEstado($estado): string
    {
        return match ($estado) {
            'pendiente' => '<span class="badge bg-warning">Pendiente</span>',
            'enviada' => '<span class="badge bg-primary">Enviada</span>',
            'respondida' => '<span class="badge bg-success">Respondida</span>',
            'no respondida' => '<span class="badge bg-danger">No Respondida</span>',
            default => '<span class="badge bg-secondary">' . e($estado) . '</span>', // En caso de estado desconocido, mostramos el valor original.
        };
    }*/
}
