<?php

namespace Database\Seeders;

use App\Models\Categorias;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categorias::create(['nombre'     => 'Hosting', 'slug' => 'hosting', 'Descripcion' => 'Servicio de alojamiento en línea que te permite publicar un sitio o aplicación web en Internet. Cuando obtienes un hosting, básicamente alquilas un espacio en un servidor que almacena todos los archivos y datos de tu sitio web para que funcione correctamente', 'cotizable'=> false]);
        Categorias::create(['nombre'     => 'Dominios', 'slug' => 'dominio', 'Descripcion' => 'Es un nombre único que identifica a una subárea de internet. El propósito principal de los nombres de dominio en Internet y del sistema​ de nombres de dominio, es traducir las direcciones IP de cada activo en la red, a términos memorizables y fáciles de encontrar', 'cotizable'=> false]);
        Categorias::create(['nombre'     => 'Desarrollo Web', 'slug' => 'Desarrollo-web', 'Descripcion' => 'Diseño, creación y realización de mantenimiento a páginas y aplicaciones web','cotizable'=> true]);

    }
}
