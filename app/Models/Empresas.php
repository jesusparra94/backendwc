<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;

   protected $primaryKey= 'id_empresa';

   protected $fillable = [
                'nombre',
                'rut',
                'email',
                'telefono',
                'giro',
                'direccion',
                'ciudad',
                'comuna',
                'user_id'
            ];


    public function serviciosempresa(){

        return $this->hasMany(Servicios::class,'empresa_id','id_empresa')->where('estado_id','=', 2);
    }

    public function ventasempresa(){

        return $this->hasMany(Ventas::class,'empresa_id','id_empresa')->where('estado_id','=', 7);
    }

}
