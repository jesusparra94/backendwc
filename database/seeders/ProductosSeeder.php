<?php

namespace Database\Seeders;

use App\Models\CaracteristicasProductos;
use App\Models\Dolars;
use App\Models\Productos;
use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $producto = Productos::create(['nombre'=> 'Hosting 5GB',
                                    'slug' => 'hosting-5gb',
                                    'meta_title' => 'Hosting 5GB',
                                    'meta_description' => 'Hosting 5GB' ,
                                    'meta_key' => 'Hosting 5GB' ,
                                    'precio' => 4500,
                                    'visible' => null,
                                    'categoria_id' => 1]);

        $caracteristicas = [
            ["nombre" => 'Dominios', "capacidad" => '1'],
            ["nombre" => 'Disco SSD', "capacidad" => '5 GB'],
            ["nombre" => 'Correos Electrónicos', "capacidad" => '10'],
            ["nombre" => 'Bases de Datos', "capacidad" => '3']
        ];

        foreach ($caracteristicas as $key => $value) {

            CaracteristicasProductos::create([
                'nombre' => $value["nombre"],
                'capacidad' => $value["capacidad"],
                'producto_id' => $producto->id_producto
            ]);
        }


        $producto = Productos::create(['nombre'=> 'Hosting 10GB',
                                    'slug' => 'hosting-10gb',
                                    'meta_title' => 'Hosting  10GB',
                                    'meta_description' => 'Hosting 10GB' ,
                                    'meta_key' => 'Hosting 10GB' ,
                                    'precio' => 5500,
                                    'visible' => null,
                                    'categoria_id' => 1]);

        $caracteristicas = [
            ["nombre" => 'Dominios', "capacidad" => '2'],
            ["nombre" => 'Disco SSD', "capacidad" => '10 GB'],
            ["nombre" => 'Correos Electrónicos', "capacidad" => '30'],
            ["nombre" => 'Bases de Datos', "capacidad" => '4']
        ];

        foreach ($caracteristicas as $key => $value) {

            CaracteristicasProductos::create([
                'nombre' => $value["nombre"],
                'capacidad' => $value["capacidad"],
                'producto_id' => $producto->id_producto
            ]);
        }


        $producto = Productos::create(['nombre'=> 'Hosting 20GB',
                                    'slug' => 'hosting-20gb',
                                    'meta_title' => 'Hosting 20GB',
                                    'meta_description' => 'Hosting 20GB' ,
                                    'meta_key' => 'Hosting 20GB' ,
                                    'precio' => 7500,
                                    'visible' => null,
                                    'categoria_id' => 1]);


        $caracteristicas = [
            ["nombre" => 'Dominios', "capacidad" => '3'],
            ["nombre" => 'Disco SSD', "capacidad" => '20 GB'],
            ["nombre" => 'Correos Electrónicos', "capacidad" => 'Ilimitadas'],
            ["nombre" => 'Bases de Datos', "capacidad" => 'Ilimitadas']
        ];

        foreach ($caracteristicas as $key => $value) {

            CaracteristicasProductos::create([
                'nombre' => $value["nombre"],
                'capacidad' => $value["capacidad"],
                'producto_id' => $producto->id_producto
            ]);
        }

        $producto = Productos::create(['nombre'=> 'Dominios',
                                    'slug' => 'dominios',
                                    'meta_title' => 'Dominios',
                                    'meta_description' => 'Dominios' ,
                                    'meta_key' => 'Dominios' ,
                                    'precio' => 0,
                                    'visible' => null,
                                    'categoria_id' => 2]);


        $dolar = Dolars::create(['precio'=> 870]);


    }
}
