<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdenCompraController extends Controller
{
    //retornar la vista index
    public function index(){
        return view('admin.orden-compras.index');
    }

    /*retornar la vista create
    public function create(){
        return view('admin.orden-compras.create');
    }*/




}
