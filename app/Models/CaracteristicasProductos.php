<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaracteristicasProductos extends Model
{
    use HasFactory;
    protected $table = 'carateristicas_productos';
    protected $primaryKey="id_caracteristica";

    protected $fillable = [
        'nombre',
        'capacidad',
        'producto_id'
    ];


}
