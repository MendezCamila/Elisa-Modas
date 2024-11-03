<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variant;
use App\Models\OrdenCompra;

class DetalleOrdenCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'cantidad',
        'precio_unitario',
        'orden_compra_id',
        'variant_id',
    ];

    //relacion uno a muchos inversa con variantes
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    //relacion uno a muchos inversa con orden compra
    public function ordenCompra()
    {
        return $this->belongsTo(OrdenCompra::class);
    }
}
