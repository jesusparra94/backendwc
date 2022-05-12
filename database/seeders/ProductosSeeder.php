<?php

namespace Database\Seeders;

use App\Models\CarateristicasProductos;
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
                                    'precio' => 5900,
                                    'visible' => null,
                                    'categoria_id' => 1]);


        $producto = Productos::create(['nombre'=> 'Hosting 10GB',
                                    'slug' => 'hosting-10gb',
                                    'meta_title' => 'Hosting  10GB',
                                    'meta_description' => 'Hosting 10GB' ,
                                    'meta_key' => 'Hosting 10GB' ,
                                    'precio' => 8900,
                                    'visible' => null,
                                    'categoria_id' => 1]);


        $producto = Productos::create(['nombre'=> 'Hosting 20GB',
                                    'slug' => 'hosting-20gb',
                                    'meta_title' => 'Hosting 20GB',
                                    'meta_description' => 'Hosting 20GB' ,
                                    'meta_key' => 'Hosting 20GB' ,
                                    'precio' => 12900,
                                    'visible' => null,
                                    'categoria_id' => 1]);


        $producto = Productos::create(['nombre'=> 'Dominios',
                                    'slug' => 'dominios',
                                    'meta_title' => 'Dominios',
                                    'meta_description' => 'Dominios' ,
                                    'meta_key' => 'Dominios' ,
                                    'precio' => 0,
                                    'visible' => null,
                                    'categoria_id' => 2]);




    }
}
