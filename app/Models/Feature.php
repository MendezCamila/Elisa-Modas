<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $fillable=[
        'value',
        'description',
        'option_id',
    ];

    //Relacion de uno a muchos(Inversa)
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    //Relacion de muchos a muchos
    //Muchas features pueden estar presente en un variante
    //Y una variante puede tener muchas features
    public function variants()
    {
        return $this->belongsToMany(Variant::class)
        ->withTimestamps();

    }



}

