<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_venta';

    protected $fillable = [
            'codigo',
            'neto',
            'descuento',
            'iva',
            'total_peso',
            'total_usd',
            'precio_usd',
            'precio_uf',
            'empresa_id',
            'estado_id',
            'estado_facturacion',
            'metodo_pago',
            'fecha_pago',
            'hora_pago'
    ];

    public function detallesventa(){

        return $this->hasMany(DetalleVentas::class,'venta_id','id_venta');
    }

    public function empresa(){

        return $this->belongsTo(Empresas::class,'empresa_id','id_empresa');
    }
}
