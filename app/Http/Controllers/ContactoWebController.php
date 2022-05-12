<?php

namespace App\Http\Controllers;

use App\Models\ContactoWeb;
use App\Mail\ConsultaWeb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class ContactoWebController extends Controller
{
    //
    public function registrar(Request $request){
        $data = request();

        if($data!='[]'){
            $registro = ContactoWeb::create([
                'nombre' => $data['nombre'],
                'email' => $data['email'],
                'telefono'  => $data['telefono'],
                'mensaje'  => $data['mensaje'],
                'ip' => $this->obtenerip()
            ]);
            if($registro){
                //enviar correo
                //mail usuario
                Mail::to($data['email'])->send(new ConsultaWeb($data['nombre'],$data['email'],$data['telefono'],$data['mensaje'],'usuario'));

                //mail admin wc
                Mail::to('jdparrau@gmail.com')->send(new ConsultaWeb($data['nombre'],$data['email'],$data['telefono'],$data['mensaje'],'admin'));
                return 1;
            }else{
                return 0;
            }
        }

    }

    public function obtenerip(){
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
       
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
    
        return $_SERVER['REMOTE_ADDR'];
    }
}
