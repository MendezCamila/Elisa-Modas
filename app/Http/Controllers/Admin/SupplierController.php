<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use DragonCode\Contracts\LangPublisher\Provider;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return view('admin.supplier.index');
    }

    public function create()
    {
        return view('admin.supplier.create');
    }

    /*
    //eliminado logico de un usuario
    public function destroy(Supplier $supplier)
    {
        //eliminamos
        $supplier->delete();

        //mensaje de exito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Proveedor eliminado!',
            'text' => 'El proveedor ha sido eliminado correctamente.'
        ]);

        //redireccionamos
        return redirect()->route('admin.suppliers.index');
    }...*/

    public function edit(Supplier $supplier)
    {
        return view('admin.supplier.edit', compact('supplier'));
    }

}
