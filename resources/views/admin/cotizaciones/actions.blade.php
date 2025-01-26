<div class="btn-group" role="group" aria-label="Acciones">
    <a href="{{ route('admin.cotizaciones.showAdmin', $cotizacion->id) }}" class="btn btn-sm btn-info">
        Ver Cotización
    </a>
    @if($cotizacion->estado == 'respondida')
        <a href="{{ route('admin.cotizaciones.respuesta', $cotizacion->id) }}" class="btn btn-sm btn-success">
            Ver Respuesta
        </a>
    @endif
</div>
