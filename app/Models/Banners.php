<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory;

    protected $primaryKey= 'id_banner';

   protected $fillable = [
            
            'banner',
            'banner_movil',
            'link',
            'title',
            'alt',
            'estado',
            'titulo',
            'texto',
            'posicion'
            
            ];
}
