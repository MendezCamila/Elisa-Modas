<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrdenCompra;
use App\Models\Cotizacion;
use App\Models\Subcategory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'cuit',
        'email',
        'phone',
        'estado',
    ];

    //relacion uno a muchos con orden compra
    public function ordenCompras()
    {
        return $this->hasMany(OrdenCompra::class);
    }

    //relacion uno a muchos con cotizacion
    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }

    //relacion muchos a muchos con subcategorias
    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class)
                    ->withTimestamps();
    }



    //pasar todo a mayusculas
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($supplier) {
            $supplier->name = strtoupper($supplier->name);
            $supplier->last_name = strtoupper($supplier->last_name);
            //$supplier->email = strtoupper($supplier->email);
        });
    }
}
