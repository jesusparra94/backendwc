<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    protected $primaryKey="id_categoria";

    protected $fillable = [
        'nombre',
        'descripcion',
        'slug',
        'cotizable'
    ];

    public function subcategoria(){

        return $this->hasMany(Subcategorias::class,'categoria_id','id_categoria');
    }
}
