<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=[
        'sku',
        'name',
        'description',
        'image_path',
        'price',
        'subcategory_id'
    ];



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

