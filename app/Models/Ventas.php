<?php

namespace App\Models;

use App\Observers\VentaObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use OwenIt\Auditing\Contracts\Auditable;

class Ventas extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //registrar el observer
    //#[ObservedBy([VentaObserver::class])]

    //fillable
    protected $fillable = [
        'user_id',     // ID del usuario
        'content',     // Contenido del carrito (probablemente un JSON o string serializado)
        'payment_id',  // ID de pago de MercadoPago
        'total',       // Total de la venta
        'estado',      // Estado de la venta
    ];

    use HasFactory;

    protected $casts = [
        'content' => 'array'
    ];

    //definir relacion con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
