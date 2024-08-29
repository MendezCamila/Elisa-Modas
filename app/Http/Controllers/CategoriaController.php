<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Family;

class CategoriaController extends Controller
{
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }
}
