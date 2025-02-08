<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PreVenta;

class Reserva extends Model
{
    protected $table = 'reservas';
    protected $fillable = [
        'pre_venta_id',
        'user_id',
        'cantidad',
        'estado',
    ];
    use HasFactory;

    //relacion inversa con pre_venta
    public function preVenta()
    {
        return $this->belongsTo(PreVenta::class);
    }
}
