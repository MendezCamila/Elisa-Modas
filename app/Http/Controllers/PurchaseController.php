<?php

namespace App\Http\Controllers;
use App\Models\Ventas;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index(){
        $user = auth()->user();
        $purchases = Ventas::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('purchases.index', compact('purchases'));
    }

    public function show($id){
        $purchase = Ventas::findOrFail($id);
        return view('purchases.show', compact('purchase'));
    }
}
