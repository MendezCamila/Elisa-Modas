<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    //fillable
    protected $fillable = [
        'user_id',     // ID del usuario
        'content',     // Contenido del carrito (probablemente un JSON o string serializado)
        'payment_id',  // ID de pago de MercadoPago
        'total',       // Total de la venta
    ];

    use HasFactory;

    protected $casts = [
        'content' => 'array'
    ];
}
