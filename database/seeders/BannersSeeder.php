<?php

namespace Database\Seeders;

use App\Models\Banners;
use Illuminate\Database\Seeder;

class BannersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Banners::create([
        	'banner' => '87imagen_banner15.png',
            'banner_movil' => '87imagen_banner_movil47.jpeg',
            'link' => 'https://www.creattiva.cl/ecommerce/tienda-online/',
            'title' => 'Crea tu tienda online',
            'alt' => 'Crea tu tienda online',
            'estado' => 1,
            'titulo' => 'Crea tu tienda online',
            'texto' => '<p>Crea tu tienda online en 30 minutos y comienza a vender por Internet con la mejor plataforma de comercio electr&oacute;nico. <br>M&aacute;s de 10.000 tiendas online han elegido nuestra soluci&oacute;n de ecommerce.<br></p>',
            'posicion' => 0

        ]);

        Banners::create([
        	'banner' => '92imagen_banner13.jpeg',
            'banner_movil' => 'imagen_banner_movil78.jpeg',
            'link' => 'https://www.creattiva.cl/streaming-audio/',
            'title' => 'Crea tu propia radio online',
            'alt' => 'Crea tu propia radio online',
            'estado' => 1,
            'titulo' => 'Crea tu propia radio online',
            'texto' => '<p>Con Streaming Radio Chile transmite m&uacute;sica, entrevistas, eventos y todo el audio que se te ocurra. <br>Lo &uacute;nico que necesitas es un notebook o PC conectado a internet.</p>',
            'posicion' => 0

        ]);
    }
}
