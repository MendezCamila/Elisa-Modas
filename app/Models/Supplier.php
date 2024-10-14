<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
    ];

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
