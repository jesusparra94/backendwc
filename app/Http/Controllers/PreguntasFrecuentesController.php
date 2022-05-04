<?php

namespace App\Http\Controllers;

use App\Models\PreguntasFrecuentes;
use Illuminate\Http\Request;

class PreguntasFrecuentesController extends Controller
{
    //
    public function showall(){

        $preguntas = PreguntasFrecuentes::all();

        foreach($preguntas as $key=>$value){
            $value->titulo = utf8_decode($value['TITULO_PAGINA']);
        }

        return $preguntas;

    }

    public function getfaq($slug){

        $pregunta = PreguntasFrecuentes::where('URL_PAGINA','=',$slug)->get();

        foreach($pregunta as $key=>$value){
            $value->titulo = utf8_decode($value['TITULO_PAGINA']);
        }

        return $pregunta;

    }

    public function buscarpreguntasfrecuentes ($nombre){

        $preguntasf =  PreguntasFrecuentes::where([['URL_PAGINA','like','%'.$nombre.'%']])->get();

        foreach($preguntasf as $key=>$value){
            $value->titulo = utf8_decode($value['TITULO_PAGINA']);
        }

        return $preguntasf;
     }
}
