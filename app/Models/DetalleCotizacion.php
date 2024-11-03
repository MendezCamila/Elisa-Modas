<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cotizacion;
use App\Models\Variant;

class DetalleCotizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'precio',
        'cantidad',
        'tiempo_entrega',
        'cotizacion_id',
        'variant_id'
    ];

    //relacion uno a muchos inversa con cotizacion
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    //relacion uno a muchos inversa con variantes
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
