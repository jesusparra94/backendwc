<?php

namespace App\Http\Controllers;

use App\Models\Periodos;
use App\Models\Dominios;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DominiosController extends Controller
{

    public function getdominio(Request $request){

        $data = request();

        $extension = $data['ext'];

        if($data['ext'] == 'cl'){

            $extensiones =[

                "$extension",

                "com",

                "net",

                "org",

                "info"

            ];

        }else if($data['ext'] == 'com'){

            $extensiones =[

                "$extension",

                "cl",

                "net",

                "org",

                "info"

            ];


        }else{

            $extensiones =[

                "$extension",

                "cl",

                "com",

                "net",

                "org",

            ];
        }

        $dominios = explode(",",$data['dominio']);

        $domintex = [];


        for ($i=0; $i < count($extensiones); $i++) {

            for ($j=0; $j < count($dominios) ; $j++) {

                array_push($domintex, ["extension" => "$extensiones[$i]", "name"=> "$dominios[$j]"]);

            }

        }

        $resp = Http::post('https://api.openprovider.eu/v1beta/auth/login',[
            'ip' => "200.35.158.254",
            'password' => "2021-Open$",
            'username' => "soporte@creattiva.cl"
        ]);

        $dn = json_decode($resp, true);

        $token = $dn["data"]["token"];

        $respdominio = Http::withToken($token)->post('https://api.openprovider.eu/v1beta/domains/check', [
            'domains' => $domintex,
            'with_price'=> true
        ]);

        $dominiosarray = json_decode($respdominio, true);


        return json_encode($dominiosarray) ;

    }

    public function dominios($dominio,$extension){

        if($extension == 'cl'){

            $extensiones =[

                "$extension",

                "com",

                "net",

                "org",

            ];

        }else if($extension == 'com'){

            $extensiones =[

                "$extension",

                "cl",

                "net",

                "org",

            ];


        }else{

            $extensiones =[

                "$extension",

                "cl",

                "com",

                "net",

                "org",

            ];
        }

        $dominios = explode(",",$dominio);

        $domintex = [];


        for ($i=0; $i < count($extensiones); $i++) {

            for ($j=0; $j < count($dominios) ; $j++) {

                array_push($domintex, ["extension" => "$extensiones[$i]", "name"=> "$dominios[$j]"]);

            }

        }

        $resp = Http::post('https://api.openprovider.eu/v1beta/auth/login',[
            'ip' => "200.35.158.254",
            'password' => "2021-Open$",
            'username' => "soporte@creattiva.cl"
        ]);

        $dn = json_decode($resp, true);

        $token = $dn["data"]["token"];

        $respdominio = Http::withToken($token)->post('https://api.openprovider.eu/v1beta/domains/check', [
            'domains' => $domintex,
            'with_price'=> true
        ]);

        $dominiosarray = json_decode($respdominio, true);

        return json_encode($dominiosarray) ;

        ;
    }

}
