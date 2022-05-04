<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = "id_producto";


    protected $fillable = [

        'nombre',
        'slug',
        'meta_title',
        'meta_description',
        'meta_key',
        'precio',
        'visible',
        'categoria_id'

    ];

    public function caracteristicas(){

        return $this->hasMany(CaracteristicasProductos::class,'producto_id','id_producto');
    }

    public function categoria(){

        return $this->belongsTo(Categorias::class,'categoria_id');
    }

    public function periodosproducto(){

        return $this->hasMany(ProductosHasPeriodos::class,'producto_id','id_producto');
    }


}
