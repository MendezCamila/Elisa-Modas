<div>
    @if ($preVenta->estado === 'activo')
        <a href="{{ route('admin.pre-ventas.reception', $preVenta->id) }}" class="btn btn-blue">
            Registrar Recepción
        </a>
    @endif
</div>
