<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cotizacion;
use App\Models\Variant;
use OwenIt\Auditing\Contracts\Auditable;

class DetalleCotizacion extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = [
        'precio',
        'cantidad',
        'tiempo_entrega',
        'cotizacion_id',
        'variant_id',
        'cantidad_solicitada',
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
