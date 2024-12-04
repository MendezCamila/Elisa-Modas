<?php

namespace App\Livewire\Admin\Auditorias;

use Livewire\Component;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

//pdf
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class AuditTable extends DataTableComponent
{
    use WithPagination;
    //usar el modelo de la auditoria
    protected $model = Audit::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('Usuario', 'user_id')
                ->sortable(),

            Column::make('Nombre y Apellido', 'user_id')
                ->format(function ($value) {
                    // Obtener el usuario relacionado
                    $user = \App\Models\User::find($value);
                    if ($user) {
                        return $user->name . ' ' . $user->last_name; // Concatenar nombre y apellido
                    }
                    return 'Usuario no encontrado'; // En caso de que no se encuentre el usuario
                })
                ->sortable(),

            Column::make('Evento', 'event')
                ->sortable(),
            Column::make('Modelo', 'auditable_type')
                ->sortable(),
            Column::make('Valores Nuevos', 'new_values')
                ->format(function ($value) {
                    $decoded = is_array($value) ? $value : json_decode($value, true); // Verificar tipo de dato
                    if (is_array($decoded)) {
                        // Excluir el campo "password"
                        $filtered = collect($decoded)->except(['password']);
                        return '<ul>' . $filtered->map(function ($val, $key) {
                            return "<li><strong>{$key}:</strong> {$val}</li>";
                        })->join('') . '</ul>';
                    }
                    return 'Sin datos';
                })
                ->html(), // Permite contenido HTML en la columna
            Column::make('Valores Antiguos', 'old_values')
                ->format(function ($value) {
                    // Decodificar valores o verificar si están vacíos
                    $decoded = is_array($value) ? $value : json_decode($value, true);
                    if (empty($decoded)) {
                        return 'Sin valores'; // Mostrar mensaje si no hay valores
                    }
                    // Excluir el campo "password" y mostrar los valores restantes
                    $filtered = collect($decoded)->except(['password']);
                    return '<ul>' . $filtered->map(function ($val, $key) {
                        return "<li><strong>{$key}:</strong> {$val}</li>";
                    })->join('') . '</ul>';
                })
                ->html(),
            Column::make('Fecha', 'created_at')
                ->format(function ($value) {
                    // Formatear la fecha en el formato día/mes/año
                    return \Carbon\Carbon::parse($value)->format('j/n/Y');
                })
                ->sortable(),
        ];
    }

    public function query()
    {
        return Audit::query();
    }

    public function rowView(): string
    {
        return 'livewire-tables.rows.audit_table';
    }
}
