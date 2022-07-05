<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;
use App\Models\Dolars;

date_default_timezone_set("America/Santiago");

class GetDolarToday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:getdolartoday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene el valor del dolar en el dia';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('https://mindicador.cl/api/dolar');
        $datos = $response->json();

        $hoy = date('d-m-Y');
        $dolarHoy = date('d-m-Y', strtotime($datos['serie'][0]['fecha']));

        if($dolarHoy==$hoy){

            $lastData = Dolars::max('created_at');

            if(date('d-m-Y', strtotime($lastData))!==$hoy){

                Dolars::create(['precio'=>$datos['serie'][0]['valor']]);

            }

        }

        $this->info('Finalizado');
    }
}
