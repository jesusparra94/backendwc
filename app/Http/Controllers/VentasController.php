<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function showpendpago($id){
        return Ventas::where([['empresa_id', $id], ['estado_id',1]])->with('detallesventa','detallesventa.servicios')->get();
    }

    public function showpagada($codigo){
        return Ventas::where([['codigo', $codigo], ['estado_id',2]])->with('detallesventa','detallesventa.servicios.productos')->first();
    }

    public function showrechazada($codigo){
        return Ventas::where([['codigo', $codigo], ['estado_id',3]])->with('detallesventa','detallesventa.servicios.productos')->first();
    }
}
