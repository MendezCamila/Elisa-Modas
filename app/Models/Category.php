<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'family_id'
    ];

    //Generamos la relacion pero inversa
    //de muchos a uno
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    //Relacion de uno a muchos
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }
}
