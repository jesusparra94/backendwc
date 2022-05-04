<?php

namespace Database\Seeders;

use App\Models\Dolar;
use Illuminate\Database\Seeder;

class DolarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dolar::create(['precio'=> 830]);
    }
}
