<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'type',
    ];
    //Relacion de muchos a muchos
    //Muchas opciones pueden tener muchos productos
    public function products()
    {
        return $this->belongsToMany(Product::class)
        ->withPivot('value')
        ->withTimestamps();

    }
    //Relacion de uno a muchos
    public function features()
    {
        return $this->hasMany(Feature::class);
}
}
