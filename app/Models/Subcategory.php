<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Supplier;
use OwenIt\Auditing\Contracts\Auditable;

class Subcategory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;

    protected $fillable=[
        'name',
        'category_id'
    ];

    //De muchos a uno
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //Una subcategoria puede tener muchos productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    //relacion muchos a muchos con proveedores
    public function proveedores()
    {
        return $this->belongsToMany(Supplier::class)
                    ->withTimestamps();
    }
}
