<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Comunas;
use App\Models\Regiones;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function show (){
        return Categorias::get();
    }

    public function showregiones (){
        return Regiones::all();
    }

    public function showcomunas ($id){

        return Comunas::where('COM_REGION_ID', $id)->get();

    }

    public function validarnombrecategoria($nombre){

       $categoria =  Categorias::where('nombre', $nombre)->first();

         if($categoria){
             return 1;
         }else{

             return 0;
         }

    }

    public function store(Request $request){

        $slug = $this->GenerarSlug($request->nombre,$request->id_categoria);

        $caretgoria =  Categorias::updateOrCreate(['id_categoria' => $request->id_categoria],[
                                                  'nombre' => $request->nombre,
                                                  'descripcion' => $request->descripcion,
                                                  'slug' => $slug,
                                                  'cotizable' => $request->cotizable
                                                ]);

        return $caretgoria;

    }

    public function GenerarSlug($name, $id = null){
        $max = 100;
        $out = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $out = substr(preg_replace("/[^-\/+|\w ]/", '', $out), 0, $max);
        $out = strtolower(trim($out, '-'));
        $out = preg_replace("/[\/_| -]+/", '-', $out);

        $equal = 0;
        if($id == null){
            $prod = Categorias::where('slug', $out)->first();
        }else{
            $prod = Categorias::where('slug', $out)->where('id_categoria', '!=', $id)->first();
        }

        while(!empty($prod))
        {
            $equal++;
            $outprueba = $out.'-'.$equal;
            $prod = Categorias::where('slug', $outprueba)->first();

            if(empty($prod))
            {
                $out = $out.'-'.$equal;
                return $out;
            }
        }

        return $out;
    }

    public function destroy(Categorias $categoria){

        return $categoria->delete();
    }


}
