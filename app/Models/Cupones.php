<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupones extends Model
{
    use HasFactory;

    protected $primaryKey= 'id_cupon';

   protected $fillable = [
                'cupon',
                'valor',
                'fecha_vec',
                'tipo_descuento_id',
                'estado_id',
                'servicio_id',
                'subcategoria_id',
                'uso_max',
                'uso_actual'
            ];
}
