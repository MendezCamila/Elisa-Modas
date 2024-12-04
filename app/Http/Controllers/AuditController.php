<?php

namespace App\Http\Controllers;
use OwenIt\Auditing\Models\Audit;

use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index()
    {
        //Obtiene las auditorias
        $audits = Audit::all();

        return view('admin.auditorias.index', compact('audits'));
    }
}
