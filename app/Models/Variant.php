<?php

namespace App\Models;

use App\Observers\VariantObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Models\DetalleCotizacion;
use App\Models\DetalleOrdenCompra;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\preVenta;


#[ObservedBy([VariantObserver::class])]
class Variant extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    // Definir constantes para los estados (opcional)
    const ESTADO_PREVENTA = 'preventa';
    const ESTADO_DISPONIBLE = 'disponible';

    protected $fillable=[
        'sku',
        'stock',
        'stock_min',
        'product_id',
        'image_path',
        'estado',
    ];

    protected function image():Attribute
    {
        return Attribute::make(
            get: fn() =>$this -> image_path ? Storage::url($this->image_path) : asset('img/sinimagen.PNG'),
        );
    }

    //Una variante tiene muchos productos
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //Relacion de muchos a muchos
    //Muchas features pueden estar presente en un variante
    //Y una variante puede tener muchas features
    public function features()
    {
        return $this->belongsToMany(Feature::class)
        ->withTimestamps();

    }

    //relacion de uno a muchos con detalle cotizacion
    public function detalleCotizaciones()
    {
        return $this->hasMany(DetalleCotizacion::class);
    }

    //relacion uno a muchos con detalle orden compra
    public function detalleOrdenCompras()
    {
        return $this->hasMany(DetalleOrdenCompra::class);
    }

    //relacion con pre_ventas (una variante puede tener muchas campañas a lo largo del tiempo)
    public function preVentas()
    {
        return $this->hasMany(preVenta::class);
    }

    protected static function booted()
    {
        // Al crear la variante
        static::creating(function ($variant) {
            if ($variant->stock > 0) {
                $variant->estado = self::ESTADO_DISPONIBLE;
            } else {
                $variant->estado = self::ESTADO_PREVENTA;
            }
        });

        // Al actualizar la variante
        static::saving(function ($variant) {
            if ($variant->stock > 0) {
                $variant->estado = self::ESTADO_DISPONIBLE;
            } else {
                $variant->estado = self::ESTADO_PREVENTA;
            }
        });
    }
}
