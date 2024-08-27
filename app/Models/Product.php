<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'sku',
        'name',
        'description',
        'image_path',
        'price',
        'stock',
        'subcategory_id'
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn() =>Storage::url($this->image_path),
        );
    }



    //muchos productos pertenecen a una Subcategoria
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }


    //Un producto puede tener muchas variantes
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    //Relacion de muchos a muchos
    //Muchos productos pueden tener muchas opciones
    public function options()
    {
        return $this->belongsToMany(Option::class)
        ->using(OptionProduct::class)
        ->withPivot('features')
        ->withTimestamps();

    }

}

