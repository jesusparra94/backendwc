<?php

namespace App\Http\Controllers;

use App\Flow\Flow as FlowFlow;
use App\Models\DetalleVentas;
use App\Models\Dolar;
use App\Models\Dolars;
use App\Models\Empresas;
use App\Models\Periodos;
use App\Models\Productos;
use App\Models\Servicios;
use App\Models\Cupones;
use App\Models\User;
use App\Models\Ventas;
use App\Mail\RegistroCliente;
use App\Mail\ConfirmacionCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Facades\App\Flow\Flow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

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

            $codeventa = Ventas::max('codigo')+100;

            if(isset($codeventa)){
                $codeventa = $codeventa + 1;
            }else{
                $codeventa = 10000;
            }

            // consultamos el precio del dolar

            $precio_dolar = Dolars::orderBy('id_dolar', 'desc')->first();
            $precio_dolar = $precio_dolar->precio+10;

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


                if($value["categoria_id"] == 2){

                    $descuento = 0;

                    $descuentof = 0;

                    $precio_unitario = round($value["precio"] * $precio_dolar); //aqui precio dolar

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

            $total_usd = round($neto / $precio_dolar);

            $venta = Ventas::create([
                                'codigo' => $codeventa,
                                'neto' => $neto,
                                'descuento' => $descuento,
                                'iva' => $iva,
                                'total_peso' => $total,
                                'total_usd' => $total_usd,
                                'precio_usd' => $precio_dolar,
                                'precio_uf' => 0,
                                'empresa_id' => $empresa->id_empresa,
                                'estado_id' => 7,
                                'metodo_pago' => 1,
                            ]);

            foreach ($request->carro as $key => $value) {


                $periodo = Periodos::where('id_periodo', $value["periodo"])->first();


                if(isset($value["producto"])){

                    if($value["categoria_id"] == 2){

                        $descuento = 0;
                        $precio_unitario = round($value["precio"] * $precio_dolar) ;
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

            }

            // pago aquí

            $urlconfirmacion = "http://apiwebcompany.local/api/pagos/confirmacion";

            $urlreturn = "http://apiwebcompany.local/api/pagos/retorno";

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

            $password = Hash::make($random);

            $user = User::create([
                'email' => filter_var($request->email, FILTER_SANITIZE_EMAIL),
                'password' => $password,
                'username' => trim($request->nombre)
            ]);

            $user_id = $user->id;

            //enviar correo de empresa creada
            Mail::to($request->email)->send(new RegistroCliente(trim($request->nombre),$request->email,$random));
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


          return  $this->cambiarestadoventapago($response["commerceOrder"]);

         }else{


           return $this->cambiarestadoventarechazado($response["commerceOrder"]);

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

            //enviar correo de confirmación de compra - ventas@webcompany.cl
            Mail::to('ventas@webcompany.cl')->send(new ConfirmacionCompra($codigoventa,$venta));
            //enviar correo de confirmación de compra - Cliente
            $cliente = empresas::where('id_empresa',$venta->empresa_id)-first();
            Mail::to($cliente->email)->send(new ConfirmacionCompra($codigoventa,$venta));


            return redirect()->away('http://localhost:3000/pago-exitoso/'.$codigoventa.'');

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

            return redirect()->away('http://localhost:3000/pago-rechazado/'.$codigoventa.'');


    }

    public function pagarventa($code){

        $venta = Ventas::where('codigo', $code)->with('empresa')->first();

        if($venta){

            $codeventa = $venta->codigo;
            $total = $venta->total_peso;

            $email = $venta->empresa["email"];

            // pago aquí

            $urlconfirmacion = "http://apiwebcompany.local/api/pagos/confirmacion";

            $urlreturn = "http://apiwebcompany.local/api/pagos/retorno";

            $params = array(

                'commerceOrder' => $codeventa,

                'subject' => "VENTA ".$codeventa,

                'currency' => 'CLP',

                'amount' => $total,

                'email' => $email,

                'paymentMethod' => 9,

                'urlConfirmation' => $urlconfirmacion,

                'urlReturn' => $urlreturn

            );

            $services = 'payment/create';

            $method = "POST";

            $response = Flow::send($services,$params,$method);

            $destination = $response['url'].'?token='.$response['token'];

            return $destination;

        }else{

            return ;

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

    public function getdolar(){

        $response = Http::get('https://mindicador.cl/api/dolar');
        $datos = $response->json();

        $hoy = date('d-m-Y');
        $dolarHoy = date('d-m-Y', strtotime($datos['serie'][0]['fecha']));

        if($dolarHoy==$hoy){

            $lastData = Dolars::max('created_at');

            if(date('d-m-Y', strtotime($lastData))!==$hoy){

                Dolars::create(['precio'=>$datos['serie'][0]['valor']]);

            }

        }

        return Dolars::all();

        //return date('d-m-Y', strtotime($datos['serie'][0]['fecha']));

     }

     public function verplantilla(){

        $codigo = 100003;

        $venta = Ventas::where('codigo', $codigo)->with('detallesventa.servicios','empresa')->first();

        return view('mails.invoice', compact('venta'));

     }
    //  servicios contratados por usuario

    public function serviciosContratados(){

        $user = Auth::user();

        $empresas = Empresas::where('user_id', $user->id)->with('serviciosempresa.productos')->get();

        return $empresas;
    }
}
