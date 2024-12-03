<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Family extends Model implements Auditable
{
    use  \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable=[
        'name',
    ];

    //Relacion uno a muchos
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
