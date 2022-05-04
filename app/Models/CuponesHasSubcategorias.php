<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuponesHasSubcategorias extends Model
{
    use HasFactory;

    protected $primaryKey= 'id_cupon_has_subcategoria';

   protected $fillable = [
                'subcategoria_id',
                'cupon_id'
            ];
}
