<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreVentaController extends Controller
{
    public function index(){
        return view('admin.pre-ventas.index');
    }

    public function create(){
        return view('admin.pre-ventas.create');
    }

}
