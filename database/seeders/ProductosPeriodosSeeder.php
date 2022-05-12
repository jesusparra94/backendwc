<?php

namespace Database\Seeders;

use App\Models\ProductosHasPeriodos;
use Illuminate\Database\Seeder;

class ProductosPeriodosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $periodo = ProductosHasPeriodos::create([   'producto_id'=> 1,
                                                    'periodo_id' => 1 ]);

        $periodo = ProductosHasPeriodos::create([   'producto_id'=> 1,
                                                    'periodo_id' => 7 ]);

        $periodo = ProductosHasPeriodos::create([   'producto_id'=> 1,
                                                    'periodo_id' => 2 ]);


        $periodo = ProductosHasPeriodos::create([   'producto_id'=> 2,
                                                    'periodo_id' => 1 ]);

        $periodo = ProductosHasPeriodos::create([   'producto_id'=> 2,
                                                    'periodo_id' => 7 ]);

        $periodo = ProductosHasPeriodos::create([   'producto_id'=> 2,
                                                    'periodo_id' => 2 ]);


        $periodo = ProductosHasPeriodos::create([   'producto_id'=> 3,
                                                    'periodo_id' => 1 ]);

        $periodo = ProductosHasPeriodos::create([   'producto_id'=> 3,
                                                    'periodo_id' => 7 ]);

        $periodo = ProductosHasPeriodos::create([   'producto_id'=> 3,
                                                    'periodo_id' => 2 ]);

        
        $periodo = ProductosHasPeriodos::create([   'producto_id'=> 4,
                                                    'periodo_id' => 2 ]);

    }
}
