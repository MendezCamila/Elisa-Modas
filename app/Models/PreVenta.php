<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variant;
use App\Models\Reserva;

class PreVenta extends Model
{
    protected $table = 'pre_ventas';

    const ESTADOS =[
        'ACTIVO' => 'activo',
        'DISPONIBLE' => 'disponible',
    ];

    protected $fillable = [
        'variant_id',
        'cantidad',
        'descuento',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];
    use HasFactory;

    //relacion inversa con variant
    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    //Una campaña de pre-venta puede tener muchas reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    //metodo para actualizar el estado de la preventa
    public function actualizarEstado(){
        if ($this->fecha_fin <= now() || $this->productos_recibidos) {
            $this->estado = self::ESTADOS['DISPONIBLE'];
            $this->save();
        }
    }

}
