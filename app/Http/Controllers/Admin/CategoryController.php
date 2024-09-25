<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Family;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Listar categorias
        //Recuperar todas las categorias
        $categories = Category::orderBy('id', 'desc')
            ->with('family')
            ->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //recuperamos todo el listado de familia
        $families = Family::all();
        return view('admin.categories.create', compact('families'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //se valida
        // Se valida con mensajes personalizados
        $request->validate([
            'family_id' => 'required|exists:families,id',
            'name' => 'required|unique:categories,name',
        ], [
            'family_id.required' => 'Debe seleccionar una familia.',
            'family_id.exists' => 'La familia seleccionada no existe.',
            'name.required' => 'El campo nombre es obligatorio.',
            'name.unique' => 'El nombre de la categoría ya ha sido registrado.',
        ]);

        Category::create($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Bien hecho!',
            'text' => 'Categoria creada correctamente.'
        ]);

        //Nos redirige a la lista de familias
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //recuperamos todo el listado de familia
        $families = Family::all();
        return view('admin.categories.edit', compact('category', 'families'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //se valida
        $request->validate([
            'family_id' => 'required|exists:families,id',
            'name' => 'required',
        ]);
        //acceder a la categoria
        $category->update($request->all());

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Bien hecho!',
            'text' => 'Categoria actualizada correctamente.'
        ]);

        //Nos redirige a la lista de categorias
        return redirect()->route('admin.categories.index', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //antes de eliminar verificamos si la categoria tiene subcategorias asignadas
        // Antes de eliminar, verificamos si la familia tiene categorías asignadas
        if ($category->subcategories()->count() > 0) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Ups!',
                'text' => 'No se puede eliminar la categoria porque tiene Subcategorías asociadas.'
            ]);
            return redirect()->route('admin.categories.edit', $category);
        }

        $category->delete();

        // Establecemos un mensaje flash de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'Categoria eliminada correctamente.'
        ]);

        // Redireccionamos a la lista de categorias
        return redirect()->route('admin.categories.index');
    }
}
