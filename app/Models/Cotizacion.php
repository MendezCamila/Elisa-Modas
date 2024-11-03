<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\DetalleCotizacion;

class Cotizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'total',
        'tiempo_entrega',
        'orden_compra_id'
    ];

    //Relacion uno a muchos inversa con proveedores
    public function proveedor()
    {
        return $this->belongsTo(Supplier::class);
    }
    //relacion uno a muchos con detalle cotizacion
    public function detalleCotizaciones()
    {
        return $this->hasMany(DetalleCotizacion::class);
    }

}
