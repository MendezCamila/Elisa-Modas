<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //retornamos la vista index
    public function index(){
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    //retornamos la vista edit
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    //crear usuario
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    //eliminado logico de un usuario
    public function destroy(User $user)
    {
        //eliminamos
        $user->delete();

        //mensaje de exito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario eliminado!',
            'text' => 'El usuario ha sido eliminado correctamente.'
        ]);

        //redireccionamos
        return redirect()->route('admin.users.index');
    }

}
