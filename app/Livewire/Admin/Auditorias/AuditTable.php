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
        $this->setDefaultSort('created_at', 'desc'); // Ordenar por fecha
        $this->setPaginationEnabled();
        $this->setSortingPillsEnabled();

        $this->setSearchVisibilityStatus(true);
        $this->setSearchVisibilityEnabled();
        $this->setSearchDisabled();
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
                    if (empty($value)) {
                        return 'Sin valores'; // Si no hay valores nuevos, mostramos 'Sin valores'
                    }

                    $decoded = is_array($value) ? $value : json_decode($value, true); // Verificar tipo de dato
                    if (is_array($decoded)) {
                        // Excluir los campos que no deseas mostrar
                        $filtered = collect($decoded)->except([
                            'password',
                            'email_verified_at',
                            'two_factor_secret',
                            'two_factor_recovery_codes',
                            'two_factor_confirmed_at',
                            'remember_token',
                            'current_team_id',
                            'profile_photo_path'
                        ]);
                        return '<ul>' . $filtered->map(function ($val, $key) {
                            return "<li><strong>{$key}:</strong> {$val}</li>";
                        })->join('') . '</ul>';
                    }
                    return 'Sin datos';
                })
                ->html(), // Permite contenido HTML en la columna

            Column::make('Valores Antiguos', 'old_values')
                ->format(function ($value) {
                    if (empty($value)) {
                        return 'Sin valores'; // Si no hay valores antiguos, mostramos 'Sin valores'
                    }

                    // Decodificar valores o verificar si están vacíos
                    $decoded = is_array($value) ? $value : json_decode($value, true);
                    if (empty($decoded)) {
                        return 'Sin valores'; // Mostrar mensaje si no hay valores
                    }
                    // Excluir los campos que no deseas mostrar
                    $filtered = collect($decoded)->except([
                        'password',
                        'email_verified_at',
                        'two_factor_secret',
                        'two_factor_recovery_codes',
                        'two_factor_confirmed_at',
                        'remember_token',
                        'current_team_id',
                        'profile_photo_path'
                    ]);
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

    public function filters(): array
    {
        return [
            // Filtro de búsqueda por múltiple campos
            TextFilter::make('Buscar')
                ->filter(function ($query, $value) {
                    $query->where(function ($query) use ($value) {
                        $query->where('id', 'like', "%$value%")
                            ->orWhere('event', 'like', "%$value%")
                            ->orWhere('auditable_type', 'like', "%$value%")
                            ->orWhereHas('user', function ($query) use ($value) {
                                $query->where('name', 'like', "%$value%")
                                    ->orWhere('last_name', 'like', "%$value%");
                            });
                    });
                }),

            // Filtro por ID de usuario
            SelectFilter::make('ID de Usuario', 'user_id')
                ->options(\App\Models\User::all()->pluck('name', 'id')->toArray())
                ->filter(function ($query, $value) {
                    if ($value) {
                        $query->where('user_id', $value);
                    }
                }),

            // Filtro por Evento
            SelectFilter::make('Evento', 'event')
                ->options(Audit::select('event')->distinct()->pluck('event', 'event')->toArray())
                ->filter(function ($query, $value) {
                    if ($value) {
                        $query->where('event', $value);
                    }
                }),

            // Filtro por Modelo
            SelectFilter::make('Modelo', 'auditable_type')
                ->options(Audit::select('auditable_type')->distinct()->pluck('auditable_type', 'auditable_type')->toArray())
                ->filter(function ($query, $value) {
                    if ($value) {
                        $query->where('auditable_type', $value);
                    }
                }),

            // Filtro por rango de fechas
            DateRangeFilter::make('Rango de Fechas')
                ->config([
                    'allowInput' => true,
                    'altFormat' => 'd F, Y',
                    'ariaDateFormat' => 'd F, Y',
                    'dateFormat' => 'Y-m-d',
                    'earliestDate' => '2020-01-01',
                    'latestDate' => '2030-12-31',
                    'placeholder' => 'Selecciona un rango de fechas',
                    'locale' => 'es',
                ])
                ->filter(function ($query, array $dateRange) {
                    $minDate = $dateRange['minDate'] ?? null;
                    $maxDate = $dateRange['maxDate'] ?? null;
                    if ($minDate) {
                        $query->whereDate('created_at', '>=', $minDate);
                    }
                    if ($maxDate) {
                        $query->whereDate('created_at', '<=', $maxDate);
                    }
                }),
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
