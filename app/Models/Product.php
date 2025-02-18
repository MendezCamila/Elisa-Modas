<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use OwenIt\Auditing\Contracts\Auditable;


#[ObservedBy([ProductObserver::class])]
class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    use HasFactory;
    protected $fillable = [
        'sku',
        'name',
        'descripcion',
        'image_path',
        'price',
        'subcategory_id'
    ];

    public function scopeVerifyFamily($query, $family_id)
    {
        $query->when($family_id, function ($query, $family_id) {
            $query->whereHas('subcategory.category', function ($query) use ($family_id) {
                $query->where('family_id', $family_id);
            });
        });
    }

    public function scopeVerifyCategory($query, $category_id)
    {
        $query->when($category_id, function ($query, $category_id) {
            $query->whereHas('subcategory', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        });
    }

    public function scopeVerifySubcategory($query, $subcategory_id)
    {
        $query->when($subcategory_id, function ($query, $subcategory_id) {
            $query->where('subcategory_id', $subcategory_id);
        });
    }





    public function scopeCustomOrder($query, $orderBy)
    {
        $query->when($orderBy == 1, function ($query) {
            $query->orderBy('created_at', 'desc');
        })
            ->when($orderBy == 2, function ($query) {
                $query->orderBy('price', 'desc');
            })
            ->when($orderBy == 3, function ($query) {
                $query->orderBy('price', 'asc');
            });
    }

    public function scopeSelectFeatures($query, $selected_features)
    {
        $query->when($selected_features, function ($query) use ($selected_features) {
            $query->whereHas('variants.features', function ($query) use ($selected_features) {
                $query->whereIn('features.id', $selected_features);
            });
        });
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn() => Storage::url($this->image_path),
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

    public function getDisplayVariantsAttribute()
    {
        $variants = $this->variants;

        // Filtrar variantes disponibles para venta normal
        $disponibles = $variants->filter(function ($variant) {
            return $variant->stock > 0 && $variant->estado === 'disponible';
        });

        if ($disponibles->count() > 0) {
            return $disponibles;
        }

        // Si ninguna variante tiene stock, chequeamos si todas están en preventa
        $preventas = $variants->filter(function ($variant) {
            return $variant->stock == 0 && $variant->estado === 'preventa';
        });

        if ($preventas->count() === $variants->count() && $variants->count() > 0) {
            return $preventas;
        }

        // Por defecto, devolver todas (si hubiese un caso mixto, se podría ajustar la lógica)
        return $variants;
    }
}
