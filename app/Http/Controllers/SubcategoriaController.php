<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoriaController extends Controller
{
    public function show(Subcategory $subcategory)
    {
        return view('subcategories.show', compact('subcategory'));
    }
}
