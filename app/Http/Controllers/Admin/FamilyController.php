<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $families = Family::orderBy('id','desc')->paginate(10);
        return view('admin.families.index', compact('families'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.families.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    // Se valida
    $request->validate([
        'name' => 'required|unique:families,name',
    ], [
        'name.unique' => 'El nombre de la familia ingresado ya existe.',
        'name.required' => 'El campo nombre es obligatorio.',
    ]);

    try {
        // Se crea la familia
        Family::create($request->all());
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Bien hecho!',
            'text' => 'Familia creada correctamente.'
        ]);

        // Nos redirige a la lista de familias
        return redirect()->route('admin.families.index');
    } catch (QueryException $e) {
        if ($e->errorInfo[1] == 1062) {
            // Código de error 1062 es para violación de restricción de unicidad
            session()->flash('swal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'El nombre de la familia ya existe.'
            ]);

            return redirect()->back()->withInput();
        }

        // Manejo genérico de errores
        session()->flash('swal', [
            'icon' => 'error',
            'title' => 'Error!',
            'text' => 'Ocurrió un error al crear la familia.'
        ]);

        return redirect()->back()->withInput();
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(Family $family)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Family $family)
    {
        return view('admin.families.edit', compact('family'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Family $family)
    {
        //Se valida
        $request->validate([
            'name'=>'required'
        ]);
        //acceder a la familia
        //actualizamos
        $family->update($request->all());

        //emitir variable de sesion clase
        //mensaje de se actualizo con exito
        session()->flash('swal',[
            'icon'=>'success',
            'title'=>'Bien hecho!',
            'text'=>'Familia actualizada correctamente.'
        ]);

        return redirect()->route('admin.families.index',$family);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Family $family)
    {
        //antes de eliminar verificamos si la familia tiene categorias asignadas
        // Antes de eliminar, verificamos si la familia tiene categorías asignadas
        if ($family->categories->count() > 0) {
        session()->flash('swal', [
            'icon' => 'error',
            'title' => 'Ups!',
            'text' => 'No se puede eliminar la familia porque tiene categorías asociadas.'
        ]);

            // Redireccionamos a la página de edición de la familia
            return redirect()->route('admin.families.edit', $family);
        }
        // Eliminamos la familia
        $family->delete();

        // Establecemos un mensaje flash de éxito
        session()->flash('swal', [
        'icon' => 'success',
        'title' => 'Éxito',
        'text' => 'La familia se ha eliminado correctamente.'
        ]);

        // Redireccionamos a la lista de familias
    return redirect()->route('admin.families.index');
}
}
