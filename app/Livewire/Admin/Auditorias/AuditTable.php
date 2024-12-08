<?php

namespace App\Livewire\Admin\Auditorias;

use Livewire\Component;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Facades\Auth;
//model user
use App\Models\User;
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
        //$this->setSearchDisabled();
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->collapseOnTablet(),

            Column::make('Usuario', 'user_id')->searchable(),

            Column::make('Nombre y Apellido', 'user_id')
                ->format(function ($value) {
                    // Obtener el usuario relacionado
                    $user = \App\Models\User::find($value);
                    if ($user) {
                        return htmlspecialchars($user->name . ' ' . $user->last_name, ENT_QUOTES, 'UTF-8'); // Concatenar nombre y apellido
                    }
                    return 'Usuario no encontrado'; // En caso de que no se encuentre el usuario
                })->searchable(),

            Column::make('Evento', 'event')->searchable(),

            Column::make('Modelo', 'auditable_type'),

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
                            return "<li><strong>" . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . ":</strong> " . htmlspecialchars($val, ENT_QUOTES, 'UTF-8') . "</li>";
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
                        return "<li><strong>" . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . ":</strong> " . htmlspecialchars($val, ENT_QUOTES, 'UTF-8') . "</li>";
                    })->join('') . '</ul>';
                })
                ->html(),
            Column::make('Fecha', 'created_at')
                ->format(function ($value) {
                    // Formatear la fecha en el formato día/mes/año
                    return \Carbon\Carbon::parse($value)->format('j/n/Y');
                }),

            /*
            Column::make("Exportar")
                ->label(function ($row) {
                    return view('admin.auditorias.auditoria_pdf', ['auditoria' => $row]);
                }),*/

        ];
    }

    public function filters(): array
    {
        return [
            // Filtro por ID de usuario
            SelectFilter::make('Nombre usuario', 'user_id')
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


    public function descargarComprobante(Audit $auditoria)
{
    // Buscar auditoría por ID
    $auditoria = Audit::findOrFail($auditoria->id);

    // Obtener la información de auditoría
    $audit_metadata = $auditoria->getMetadata();
    $audit_modified_properties = $auditoria->getModified();

    // Verificar el contenido antes de continuar
    //dd('Audit Metadata:', $audit_metadata, 'Audit Modified Properties:', $audit_modified_properties);

    // Codificar a UTF-8 todos los datos en audit_metadata
    $audit_metadata = array_map(function($value) {
        return mb_convert_encoding($value, 'UTF-8', 'auto');
    }, $audit_metadata);

    // Asegurar que los valores en audit_modified_properties se codifiquen correctamente
    $audit_modified_properties = collect($audit_modified_properties)->map(function ($value) {
        // Si el valor es un array (como "old" en id, sku, etc.), no lo tocamos
        if (is_array($value)) {
            return $value;  // No hacer nada, solo devolver el array
        }

        // Si el valor es una cadena, convertirlo a UTF-8
        return mb_convert_encoding($value, 'UTF-8', 'auto');
    });

    // Verificar si todo se codificó correctamente
    foreach ($audit_modified_properties as $key => $value) {
        if (mb_check_encoding($value, 'UTF-8') === false) {
            $audit_modified_properties[$key] = 'Contenido no válido';
        }
    }

    // Verificar el estado después de la conversión
    //dd('Audit Metadata (Post Conversion):', $audit_metadata, 'Audit Modified Properties (Post Conversion):', $audit_modified_properties);

    // responsable del cambio que disparó el registro de auditoría
    $user_resp = User::find($audit_metadata['user_id']);

    foreach ($audit_modified_properties as $key => $value) {
        if (!mb_check_encoding($value, 'UTF-8')) {
            // Si encuentras un valor con codificación incorrecta, lo detienes y muestras un dd()
            dd('Invalid UTF-8 detected in value: ', $key, $value);
        }
    }


    // Datos para pasar a la vista
    $data = [
        'audit' => $auditoria,
        'user_resp' => $user_resp,
        'audit_metadata' => $audit_metadata,
        'audit_modified_properties' => $audit_modified_properties
    ];

    // Generar el PDF usando la vista
    $pdf = Pdf::loadView('admin.auditorias.pdf', $data);

    // Descargar el PDF con un nombre basado en el ID de la auditoría
    return $pdf->download('auditoria_' . $auditoria->id . '.pdf');
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
