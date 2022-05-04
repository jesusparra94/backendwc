<?php

namespace Database\Seeders;

use App\Models\TipoDescuento;
use Illuminate\Database\Seeder;

class TipoDescuentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        TipoDescuento::create(['descuento'     => 'monto fijo']);
        TipoDescuento::create(['descuento'     => 'porcentaje']);
    }
}
