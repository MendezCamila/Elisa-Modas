<div>
    @if($venta->estado == 'pendiente')
        <button wire:click="cambiarEstado({{ $venta->id }})" class="btn btn-success">
            Marcar como entregado
        </button>
    @elseif($venta->estado == 'entregado')
        <span>Venta entregada</span>
    @endif
</div>
