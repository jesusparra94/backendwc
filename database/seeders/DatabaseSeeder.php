<?php

namespace Database\Seeders;

use App\Models\Administradores;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriasSeeder::class);
        $this->call(ProductosSeeder::class);
        $this->call(PeriodosSeeder::class);
        $this->call(ProductosPeriodosSeeder::class);
        $this->call(ComunaTableSeeder::class);
        $this->call(EstadosSeeder::class);



        Administradores::create([
            'name' => 'Yuserly Bracho',
            'email' => 'yuserlybracho@gmail.com',
            'password' => Hash::make('12345678')
        ]);

    }
}
