<?php

namespace App\Http\Controllers;

use App\Flow\Flow as FlowFlow;
use App\Models\DetalleVentas;
use App\Models\Dolar;
use App\Models\Empresas;
use App\Models\Periodos;
use App\Models\Productos;
use App\Models\Servicios;
use App\Models\Cupones;
use App\Models\User;
use App\Models\Ventas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Facades\App\Flow\Flow;
use Illuminate\Support\Facades\Http;

date_default_timezone_set("America/Santiago");

class ServiciosController extends Controller
{
    public function showpendpago($id){
        return Servicios::where([['empresa_id',$id], ['estado_id', 1]])->with('detalleventa','detalleventa.venta', 'periodo')->get();
    }

    public function show($id, $subcategoria){

        $serviciossub = [];
        $servicios = Servicios::where([['empresa_id',$id], ['estado_id', '!=' ,1]])->with('detalleventa','detalleventa.venta', 'periodo', 'productos','productos.subcategoria')->get();
        if(!empty($servicios)){
            foreach ($servicios as $key => $value) {
                if($value["productos"]["subcategoria"]["slug"] == $subcategoria){
                    array_push($serviciossub, $value);
                }
            }
        }

        return $serviciossub;

    }
    public function crearservicio(Request $request){

        $empresa = Empresas::where('rut', $request->rut)->first();
        $esvalido = 0;

        if(isset($empresa)){

            if($empresa->rut == $request->rut){

                if(isset($empresa->rut) &&
                    isset($empresa->email) &&
                    isset($empresa->telefono) &&
                    isset($empresa->nombre) &&
                    isset($empresa->direccion) &&
                    isset($empresa->ciudad) &&
                    isset($empresa->comuna) ){

                    $esvalido = 1;

                }else{
                   $empresa =  $this->crearempresa($request);

                   if(isset($empresa)){

                        $esvalido = 1;
                   }
                }

            }else{

                $empresa =  $this->crearempresa($request);

                   if(isset($empresa)){

                        $esvalido = 1;
                   }

            }

        }else{

            $empresa =  $this->crearempresa($request);
            $esvalido = 1;
        }

        if($esvalido == 1){

            // creamos la venta

            $codeventa = Ventas::max('codigo');

            if(isset($codeventa)){
                $codeventa = $codeventa + 1;
            }else{
                $codeventa = 100000;
            }

            // consultamos el precio del dolar

            $dolar = Dolar::latest()
                            ->first();

            // realizamos los calculos

            $neto = 0;
            $iva = 0;
            $total = 0;
            $descuento = 0;
            $cupondescuento = 0;
            $contDominios = 0;

            foreach ($request->carro as $key => $value) {



                //periodo producto
                $periodo = Periodos::where('id_periodo', $value["periodo"])->first();

                $precio_dolar = $this->getpreciodolar();

                if($value["categoria_id"] == 2){

                    $descuento = 0;

                    $descuentof = 0;

                    $precio_unitario = round($value["precio"] * 870); //aqui precio dolar

                    $neto += ($precio_unitario - $descuento);

                }else{

                    //datos producto
                    $producto = Productos::where('id_producto', $value["id_producto"])->first();

                    $descuento = (($producto["precio"] * $periodo["meses"]) * $periodo["descuento"]  ) / 100;

                    $descuentof = 0;

                    $precio_unitario = ($producto["precio"] * $periodo["meses"]);

                    $neto += ($precio_unitario - $descuento);

                    $descuento = round($descuento + $descuentof);
                }

                // if(isset($value["code_cupon_descuento"]) && $value["cupon_descuento"]>0){

                //     //validar cupones
                //     $cupon = Cupones::where([
                //         ['cupon','=',$value["code_cupon_descuento"]]
                //     ])->first();

                //     if($cupon){

                //         if($cupon->uso_actual<$cupon->uso_max){

                //             if($cupon->tipo_descuento_id==1){

                //                 $cupondescuento = round($cupon->valor*-1);

                //             }elseif($cupon->tipo_descuento_id==2){

                //                 $cupondescuento = round((($precio_unitario*$cupon->valor)*100)*-1);

                //             }

                //             Cupones::where([
                //                 ['cupon','=',$value["code_cupon_descuento"]]
                //             ])->update(['uso_actual' => ($cupon->uso_actual+1)]);

                //         }else{
                //             $cupondescuento = 0;
                //         }

                //     }else{
                //         $cupondescuento = 0;
                //     }
                // }

            }

            $neto = $neto + $cupondescuento;
            $iva = round($neto * 0.19);
            $total = $neto + $iva;

            $total_usd = 0;

            $venta = Ventas::create([
                                'codigo' => $codeventa,
                                'neto' => $neto,
                                'descuento' => $descuento,
                                'iva' => $iva,
                                'total_peso' => $total,
                                'total_usd' => $total_usd,
                                'precio_usd' => 0,
                                'precio_uf' => 0,
                                'empresa_id' => $empresa->id_empresa,
                                'metodo_pago' => 1,
                            ]);

            foreach ($request->carro as $key => $value) {


                $periodo = Periodos::where('id_periodo', $value["periodo"])->first();

                if($value["categoria_id"] == 2){

                    $descuento = 0;
                    $precio_unitario = round($value["precio"] * 870) ;
                    $precio_descuento =  $precio_unitario - $descuento;
                    $precio_mensual = 0;
                    $glosa = $value["producto"];
                    $productoins = 4;

                }else{

                    $producto = Productos::where('id_producto', $value["id_producto"])->first();

                    $descuento = (($producto["precio"] * $periodo["meses"]) * $periodo["descuento"]) / 100;
                    $precio_descuento = round(($producto["precio"] * $periodo["meses"]) - $descuento);
                    $precio_unitario = ($producto["precio"] * $periodo["meses"]);
                    $precio_mensual = $producto["precio"];
                    $glosa = $value["nombre"].' '.$value["dominio"];
                    $productoins = $value["id_producto"];

                }


                // creamos el/los servicios



                $servicio = Servicios::create([
                                    'codigo_venta' => $venta->codigo,
                                    'glosa' => $glosa,
                                    'cantidad' => 1,
                                    'producto_id' => $productoins,
                                    'periodo_id' => $value["periodo"],
                                    'categoria_id' => $value["categoria_id"],
                                    'dominio' => $value["dominio"],
                                    'fecha_inscripcion'=> date('Y-m-d H:i:s'),
                                    'empresa_id' => $empresa->id_empresa
                                    ]);
                 // creamos el detalle de la venta

                 $detalle = DetalleVentas::create([
                                    'cantidad' => 1,
                                    'precio_mensual' => $precio_mensual,
                                    'precio_unitario' => $precio_unitario,
                                    'descuento' => $descuento,
                                    'precio_descuento' => $precio_descuento,
                                    'precio_pagado' => $precio_descuento,
                                    'venta_id' => $venta->id_venta,
                                    'servicio_id' => $servicio->id_servicio
                                ]);

            }

            // pago aquí

            $urlconfirmacion = "http://apiwebcompany.cp/api/pagos/confirmacion";

            $urlreturn = "http://apiwebcompany.cp/api/pagos/retorno";

            $params = array(

                'commerceOrder' => $codeventa,

                'subject' => "VENTA ".$codeventa,

                'currency' => 'CLP',

                'amount' => $total,

                'email' => $request->email,

                'paymentMethod' => 9,

                'urlConfirmation' => $urlconfirmacion,

                'urlReturn' => $urlreturn

            );

            $services = 'payment/create';

            $method = "POST";

            $response = Flow::send($services,$params,$method);

            $destination = $response['url'].'?token='.$response['token'];

            return $destination;

        }

    }
    public function crearempresa($request){

        $user = User::where('email',$request->email)->first();

        if($user){
            $user_id = $user->id;
        }else{

            $random = Str::random(8);

            // $random = 12345678;


            $user = User::create([
                'email' => filter_var($request->email, FILTER_SANITIZE_EMAIL),
                'password' => Hash::make($random),
                'username' => trim($request->nombre)
            ]);

            $user_id = $user->id;
        }


        $empresa = Empresas::updateOrCreate(['rut'=>$request->rut],
                                            [
                                                'nombre' => filter_var($request->nombre, FILTER_SANITIZE_STRING),
                                                'rut' => $request->rut,
                                                'email' => filter_var($request->email, FILTER_SANITIZE_EMAIL),
                                                'telefono' => filter_var($request->telefono, FILTER_SANITIZE_NUMBER_INT),
                                                'giro' => filter_var($request->giro, FILTER_SANITIZE_STRING),
                                                'direccion' => filter_var($request->direccion, FILTER_SANITIZE_STRING),
                                                'ciudad' => $request->ciudad,
                                                'comuna' => $request->comuna,
                                                'user_id' => $user_id
                                            ]);

        return $empresa;

    }

    public function returns(Request $request){

        $token = Flow::read_retorno();

         $params = array(

             'token' => $token

         );

         $services = 'payment/getStatus';

         $method = "GET";

         $response = Flow::send($services,$params,$method);


         if($response["status"] == 2){


            $this->cambiarestadoventapago($response["commerceOrder"]);

         }else{


            $this->cambiarestadoventarechazado($response["commerceOrder"]);

         }

     }

     public function confirmacion(){

        $token = Flow::read_confirm();

        $params = array(

            'token' => $token

        );

        $services = 'payment/getStatus';

        $method = "GET";

        $response = Flow::send($services,$params,$method);

        if($response["status"] == 2){

            $this->cambiarestadoventapago($response["commerceOrder"]);

        }else{

           $this->cambiarestadoventarechazado($response["commerceOrder"]);

        }


    }


    public function cambiarestadoventapago($codigoventa){

        $venta = Ventas::where('codigo', $codigoventa)->with('detallesventa')->first();

            foreach ($venta["detallesventa"] as $key => $value) {

                $servicio = Servicios::where('id_servicio',$value["servicio_id"])->first();
                $periodo = Periodos::where('id_periodo', $servicio->periodo_id)->first();

                // calcular fecha de renovacion
                $fecha_actual = date("Y-m-d");
                //sumo meses del periodo
                $meses = "+"." ". $periodo->meses . " month";
                $renovacion =  date("Y-m-d",strtotime($fecha_actual."$meses"));

                Servicios::where('id_servicio',$value["servicio_id"])->update([
                            'fecha_inicio' => date('Y-m-d'),
                            'fecha_renovacion' => $renovacion,
                            'estado_id'=> 2
                ]);

            }

            Ventas::where('codigo', $codigoventa)->update([
                        'estado_id'=> 2,
                        'fecha_pago' => date('Y-m-d'),
                        'hora_pago' => date('H:i:s'),
                    ]);


             return redirect()->away('http://localhost:3000/pago-exitoso');

    }

    public function cambiarestadoventarechazado($codigoventa){

        $venta = Ventas::where('codigo', $codigoventa)->with('detallesventa')->get();

            foreach ($venta["detallesventa"] as $key => $value) {

                Servicios::where('id_servicio',$value["servicio_id"])->update([
                            'estado_id'=> 3
                ]);

            }

            Ventas::where('codigo', $codigoventa)->update([
                'estado_id'=> 3,
                'fecha_pago' => date('Y-m-d'),
                'hora_pago' => date('H:i:s'),
            ]);

            return redirect()->away('http://localhost:3000/pago-rechazado');


    }

    public function pagarventa(Request $request){

        $venta = Ventas::where('id_venta', $request->id_venta)->first();

        $codeventa = $venta->codigo;
        $mediopago = $request->mediopago;
        if($mediopago == 1){
        $total = $venta->total_peso;

        return $this->pagowebpay($codeventa,$total,$mediopago);
        }else{
        $total = $venta->total_usd;

        return $this->pagopaypal($codeventa,$total,$mediopago);
        }

    }

    public function consultarServicios($id_empresa){

        $servicios = Servicios::where('empresa_id','=',$id_empresa)->where('estado_id','=',2)->get();

        $existe = false;
        if(count($servicios)>0){

            foreach($servicios as $key => $value){

                $producto = Productos::where('id_producto', $value['producto_id'])->first();
                if($producto->subcategoria_id==1){ //productos hosting
                    $existe = true;
                }

            }

        }else{

            $existe = false;

        }


        return ['status'=>$existe];

    }

    public function getpreciodolar(){

        $response = Http::get('https://mindicador.cl/api/dolar');
        $datos = $response->json();
        return $datos;

     }

     public function verplantilla(){

        $codigo = 100003;

        $venta = Ventas::where('codigo', $codigo)->with('detallesventa.servicios','empresa')->first();

        return view('mails.invoice', compact('venta'));

     }
}
