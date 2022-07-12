<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use App\Models\Ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // pendiente de pago

    public function pendientepago(){

        $user = Auth::user();

        $empresas = Empresas::where('user_id', $user->id)->with('ventasempresa')->get();

        return $empresas;


    }
}
