<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    //retornar la vista index
    public function index(){
        return view('admin.cotizaciones.index');
    }
}
