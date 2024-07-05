<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $fillable=[
        'sku',
        'image_path',
        'product_id'
    ];

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
}
