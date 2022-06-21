<?php

namespace Database\Seeders;

use App\Models\Periodos;
use Illuminate\Database\Seeder;

class PeriodosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Periodos::create(['periodo'=> 'Mes', 'meses' => 1, 'descuento' => 0]);
        Periodos::create(['periodo'=> '1 Año', 'meses' => 12, 'descuento' => 45]);
        Periodos::create(['periodo'=> '2 Años', 'meses' => 24, 'descuento' => 0]);
        Periodos::create(['periodo'=> '3 Años', 'meses' => 36, 'descuento' => 0]);
        Periodos::create(['periodo'=> 'Pago Unico', 'meses' => 1, 'descuento' => 0]);
        Periodos::create(['periodo'=> '3 meses', 'meses' => 3, 'descuento' => 0]);
        Periodos::create(['periodo'=> '6 meses', 'meses' => 6, 'descuento' => 40]);
    }
}
