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



#[ObservedBy([VariantObserver::class])]
class Variant extends Model
{
    use HasFactory;
    protected $fillable=[
        'sku',
        'stock',
        'stock_min',
        'product_id',
        'image_path',
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
}
