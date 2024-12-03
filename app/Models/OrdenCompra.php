<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\DetalleOrdenCompra;
use OwenIt\Auditing\Contracts\Auditable;

class OrdenCompra extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable = [
        'estado',
        'supplier_id',
    ];

    //relacion uno a muchos inversa con proveedores
    public function proveedor()
    {
        return $this->belongsTo(Supplier::class);
    }

    //relacion uno a muchos con detalle orden compra
    public function detalleOrdenCompras()
    {
        return $this->hasMany(DetalleOrdenCompra::class);
    }
}
