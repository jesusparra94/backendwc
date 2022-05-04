<?php

namespace App\Http\Controllers;

use App\Models\CaracteristicasProductos;
use App\Models\Categorias;
use App\Models\Periodos;
use App\Models\Productos;
use App\Models\ProductosHasPeriodos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductosController extends Controller
{
    public function show ($id){
       $producto =  Productos::where('id_producto',$id)->with('caracteristicas','categoria', 'periodosproducto.periodo')->first();


       foreach ($producto->periodosproducto as $key => $value) {

            $descuento = (($producto["precio"] * $value["meses"]) * $value["descuento"]  ) / 100;

            $precio_con_descuento = round(($producto["precio"] * $value["meses"]) - $descuento);

            $producto->periodosproducto[$key]["precio_trienal"]  = $precio_con_descuento;

            $producto->periodosproducto[$key]["descuento"]  = $value["descuento"];

            $producto->periodosproducto[$key]["ahorro"]  = round(($producto["precio"] * $value["meses"]) - $precio_con_descuento);
       }

       return $producto;
    }


    public function showadmin(){
        $productos =  Productos::with('caracteristicas','categoria', 'periodosproducto.periodo')->get();


        foreach ($productos as $key => $value) {

            foreach ($value["periodosproducto"] as $key1 => $value1) {

                $descuento = (($value["precio"] * $value1["meses"]) * $value1["descuento"]  ) / 100;

                $precio_con_descuento = round(($value["precio"] * $value1["meses"]) - $descuento);

                $value["periodosproducto"][$key1]["precio_trienal"]  = $precio_con_descuento;

                $value["periodosproducto"][$key1]["descuento"]  = $value1["descuento"];

                $value["periodosproducto"][$key1]["ahorro"]  = round(($value["precio"] * $value1["meses"]) - $precio_con_descuento);
           }

        }

        return $productos;
     }


    public function showcategoria ($id){
        $productos =  Productos::where('categoria_id',$id)->with('caracteristicas','categoria', 'periodosproducto.periodo')->get();


        foreach ($productos as $key => $value) {

            foreach ($value["periodosproducto"] as $key1 => $value1) {

                $descuento = (($value["precio"] * $value1["meses"]) * $value1["descuento"]  ) / 100;

                $precio_con_descuento = round(($value["precio"] * $value1["meses"]) - $descuento);

                $value["periodosproducto"][$key1]["precio_trienal"]  = $precio_con_descuento;

                $value["periodosproducto"][$key1]["descuento"]  = $value1["descuento"];

                $value["periodosproducto"][$key1]["ahorro"]  = round(($value["precio"] * $value1["meses"]) - $precio_con_descuento);
           }

        }

        return $productos;
     }


     public function showcategoriaslug ($slug){

        $categoria = Categorias::where('slug', $slug)->first();
        $productos =  Productos::where('categoria_id',$categoria->id_categoria)->with('caracteristicas','categoria', 'periodosproducto.periodo')->get();


        foreach ($productos as $key => $value) {

            foreach ($value["periodosproducto"] as $key1 => $value1) {

                $descuento = (($value["precio"] * $value1["periodo"]["meses"]) * $value1["periodo"]["descuento"]  ) / 100;

                $precio_con_descuento = round(($value["precio"] * $value1["periodo"]["meses"]) - $descuento);

                $value["periodosproducto"][$key1]["precio"]  = $precio_con_descuento;

                $value["periodosproducto"][$key1]["descuento"]  = $value1["periodo"]["descuento"];

                $value["periodosproducto"][$key1]["ahorro"]  = round(($value["precio"] * $value1["periodo"]["meses"]) - $precio_con_descuento);
           }

        }

        return $productos;
     }



    public function periodosproducto($id){

        $producto = Productos::where('id_producto', $id)->with('periodosproducto')->first();


        foreach ($producto->periodosproducto as $key => $value) {


            $descuento = (($producto["precio"] * $value["meses"]) * $value["descuento"]) / 100;

            $producto->periodosproducto[$key]["precio_descuento"] = round(($producto["precio"] * $value["meses"]) - $descuento);

            $producto->periodosproducto[$key]["precio"] = ($producto["precio"] * $value["meses"]);

            $producto->periodosproducto[$key]["precio_mensual"] = $producto["precio"];

            $producto->periodosproducto[$key]["ahorro"] = ($producto["precio"] * $value["meses"]) - round(($producto["precio"] * $value["meses"]) - $descuento);


        }

        return $producto->periodosproducto;
    }


    public function periodoproducto($id,$id_periodo){

        $producto = Productos::where('id_producto', $id)->first();
        $periodo = Periodos::where('id_periodo', $id_periodo)->first();
        $descuento = (($producto["precio"] * $periodo["meses"]) * $periodo["descuento"]) / 100;

        $periodo["precio_descuento"] = round(($producto["precio"] * $periodo["meses"]) - $descuento);

        $periodo["precio"] = ($producto["precio"] * $periodo["meses"]);

        $periodo["precio_mensual"] = $producto["precio"];

        $periodo["ahorro"] = ($producto["precio"] * $periodo["meses"]) - round(($producto["precio"] * $periodo["meses"]) - $descuento);

        return $periodo;


    }

    public function buscarproductos ($nombre){

        $productos =  Productos::where([['slug','like','%'.$nombre.'%']])->with('caracteristicas','categoria')->get();

        $periodo = Periodos::where('id_periodo',4)->first();

       foreach ($productos as $key => $value) {

            $descuento = (($value["precio"] * $periodo["meses"]) * $periodo["descuento"]  ) / 100;

            $precio_con_descuento = round(($value["precio"] * $periodo["meses"]) - $descuento);

            $productos[$key]["precio_trienal"]  = $precio_con_descuento;

            $productos[$key]["descuento"]  = $periodo["descuento"];

            $productos[$key]["ahorro"]  = round(($value["precio"] * $periodo["meses"]) - $precio_con_descuento);
       }

        return $productos;
     }

    public function showslug ($slug){



        $productos =  Productos::where('slug', $slug)->with('caracteristicas','categoria')->first();

        $periodo = Periodos::where('id_periodo',4)->first();

            $descuento = (($productos["precio"] * $periodo["meses"]) * $periodo["descuento"]  ) / 100;

            $precio_con_descuento = round(($productos["precio"] * $periodo["meses"]) - $descuento);

            $productos["precio_trienal"]  = $precio_con_descuento;

            $productos["descuento"]  = $periodo["descuento"];

            $productos["ahorro"]  = round(($productos["precio"] * $periodo["meses"]) - $precio_con_descuento);

        return $productos;
     }


     public function store(Request $request)
     {


        $slug = $this->GenerarSlug($request->nombre,$request->id_producto);

            // creamos el producto

            $producto =  Productos::updateOrCreate(['id_producto' => $request->id_producto],[
                'nombre' => $request->nombre,
                'slug' => $slug,
                'meta_title'=> $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_key'  => $request->meta_key,
                'precio' => $request->precio,
                'visible' => $request->visible,
                'categoria_id' => $request->categoria_id
              ]);

            //   borramos las caracteristicas que esten creadas

              CaracteristicasProductos::where('producto_id', $producto->id_producto)->delete();

            // creamos las caracteristicas

            for ($i=0; $i < count($request->caracteristicas) ; $i++) {

                CaracteristicasProductos::create([
                    'nombre' => $request->caracteristicas[$i]["nombre"],
                    'capacidad' => $request->caracteristicas[$i]["capacidad"],
                    'producto_id' => $producto->id_producto
                    ]);

            }

            // borramos los periodos creados

            ProductosHasPeriodos::where('producto_id', $producto->id_producto)->delete();

            // periodos productos

            for ($i=0; $i < count($request->periodos) ; $i++) {

                ProductosHasPeriodos::create([

                    'producto_id' => $producto->id_producto,
                    'periodo_id' => $request->periodos[$i]["id_periodo"],
                    ]);

            }

            return $producto;
     }

     public function GenerarSlug($name, $id = null){
        $max = 100;
        $out = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $out = substr(preg_replace("/[^-\/+|\w ]/", '', $out), 0, $max);
        $out = strtolower(trim($out, '-'));
        $out = preg_replace("/[\/_| -]+/", '-', $out);

        $equal = 0;
        if($id == null){
            $prod = Productos::where('slug', $out)->first();
        }else{
            $prod = Productos::where('slug', $out)->where('id_producto', '!=', $id)->first();
        }

        while(!empty($prod))
        {
            $equal++;
            $outprueba = $out.'-'.$equal;
            $prod = Productos::where('slug', $outprueba)->first();

            if(empty($prod))
            {
                $out = $out.'-'.$equal;
                return $out;
            }
        }

        return $out;
    }

    public function validarnombreproducto($nombre){

        $producto =  Productos::where('nombre', $nombre)->first();

          if($producto){
              return 1;
          }else{

              return 0;
          }

     }

    public function destroy(Productos $producto){

        return $producto->delete();
    }



}
