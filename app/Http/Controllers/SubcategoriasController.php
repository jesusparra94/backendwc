<?php

namespace App\Http\Controllers;

use App\Models\Subcategorias;
use Illuminate\Http\Request;

class SubcategoriasController extends Controller
{
    public function show ($id){
        return Subcategorias::where('categoria_id',$id)->with('categoria')->get();
    }
    public function showsub(){
        return Subcategorias::with('categoria','subcategoriasperiodos')->get();
    }

    public function showslug($slug){
            return Subcategorias::where('slug',$slug)->first();
    }

    public function validarnombresubcategoria($nombre){

        $subcategoria =  Subcategorias::where('nombre', $nombre)->first();

          if($subcategoria){
              return 1;
          }else{

              return 0;
          }

     }


    public function store(Request $request){

        $slug = $this->GenerarSlug($request->nombre,$request->id_subcategoria);

        $subcaretgoria =  Subcategorias::updateOrCreate(['id_subcategoria' => $request->id_subcategoria],[
                                                  'nombre' => $request->nombre,
                                                  'slug' => $slug,
                                                  'icono' => $request->icono,
                                                  'categoria_id' => $request->categoria["id_categoria"],
                                                  'preseleccionado'=> $request->preseleccionado,
                                                  'dominio'=> $request->dominio,
                                                  'ip' => $request->ip,
                                                  'sistema_operativo' => $request->sistema_operativo,
                                                  'administrable' => $request->administrable
                                                ]);

        $arraySubPeriodos = array();
        foreach($request->periodo as $item){
            array_push($arraySubPeriodos, $item['id_periodo']);
        }
        $subcaretgoria->subcategoriasperiodos()->sync($arraySubPeriodos);

        return $subcaretgoria;

    }

    public function GenerarSlug($name, $id = null){
        $max = 100;
        $out = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $out = substr(preg_replace("/[^-\/+|\w ]/", '', $out), 0, $max);
        $out = strtolower(trim($out, '-'));
        $out = preg_replace("/[\/_| -]+/", '-', $out);

        $equal = 0;
        if($id == null){
            $prod = Subcategorias::where('slug', $out)->first();
        }else{
            $prod = Subcategorias::where('slug', $out)->where('categoria_id', '!=', $id)->first();
        }

        while(!empty($prod))
        {
            $equal++;
            $outprueba = $out.'-'.$equal;
            $prod = Subcategorias::where('slug', $outprueba)->first();

            if(empty($prod))
            {
                $out = $out.'-'.$equal;
                return $out;
            }
        }

        return $out;
    }

    public function destroy(Subcategorias $subcategoria){

        return $subcategoria->delete();
    }

}
