<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function showpendpago($id){
        return Ventas::where([['empresa_id', $id], ['estado_id',1]])->with('detallesventa','detallesventa.servicios')->get();
    }
}
