<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    use HasFactory;
    protected $primaryKey= 'id_servicio';

    protected $fillable = [
            'codigo_venta',
            'glosa',
            'cantidad',
            'producto_id',
            'periodo_id',
            'categoria_id',
            'dominio',
            'fecha_inscripcion',
            'fecha_inicio',
            'fecha_renovacion',
            'empresa_id'
    ];

    public function detalleventa(){

        return $this->hasMany(DetalleVentas::class,'servicio_id','id_servicio');
    }

    public function periodo(){

        return $this->hasOne(Periodos::class,'id_periodo','periodo_id');
    }

    public function productos(){

        return $this->hasOne(Productos::class,'id_producto','producto_id');
    }
}
