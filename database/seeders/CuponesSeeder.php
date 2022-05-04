<?php

namespace Database\Seeders;

use App\Models\Cupones;
use App\Models\CuponesHasSubcategorias;
use Illuminate\Database\Seeder;

class CuponesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Cupones::create(

            [
                'cupon' => '12345',
                'valor' => '3500',
                'fecha_vec' => '2022-04-01',
                'tipo_descuento_id' => 1,
                'estado_id' => 7,
                'servicio_id' => null,
                'uso_max' => 1,
                'uso_actual' => 0
            ]

         );

        CuponesHasSubcategorias::create([
            'subcategoria_id' => 1,
            'cupon_id' => Cupones::max('id_cupon')
        ]);

        CuponesHasSubcategorias::create([
            'subcategoria_id' => 2,
            'cupon_id' => Cupones::max('id_cupon')
        ]);

        CuponesHasSubcategorias::create([
            'subcategoria_id' => 3,
            'cupon_id' => Cupones::max('id_cupon')
        ]);

        CuponesHasSubcategorias::create([
            'subcategoria_id' => 4,
            'cupon_id' => Cupones::max('id_cupon')
        ]);

        CuponesHasSubcategorias::create([
            'subcategoria_id' => 5,
            'cupon_id' => Cupones::max('id_cupon')
        ]);

        Cupones::create(

            [
                'cupon' => '67890',
                'valor' => '20',
                'fecha_vec' => '2022-04-03',
                'tipo_descuento_id' => 2,
                'estado_id' => 7,
                'servicio_id' => null,
                'uso_max' => 2,
                'uso_actual' => 0
            ]

         );

        CuponesHasSubcategorias::create([
            'subcategoria_id' => 9,
            'cupon_id' => Cupones::max('id_cupon')
        ]);
        CuponesHasSubcategorias::create([
            'subcategoria_id' => 10,
            'cupon_id' => Cupones::max('id_cupon')
        ]);
        CuponesHasSubcategorias::create([
            'subcategoria_id' => 11,
            'cupon_id' => Cupones::max('id_cupon')
        ]);
        CuponesHasSubcategorias::create([
            'subcategoria_id' => 12,
            'cupon_id' => Cupones::max('id_cupon')
        ]);
        CuponesHasSubcategorias::create([
            'subcategoria_id' => 13,
            'cupon_id' => Cupones::max('id_cupon')
        ]);
    }
}
