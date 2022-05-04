<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntasFrecuentes extends Model
{
    use HasFactory;
     protected $primaryKey = "ID_PAGINA";

     protected $fillable = [
        'TITULO_PAGINA',
        'SUBTITULO_PAGINA',
        'ID_PAGINA_PERTENECE',
        'ORDEN_PAGINA',
        'CONTENIDO_PAGINA',
        'SCRIPTS_PAGINA',
        'DESCRIPCION_PAGINA',
        'KEYWORDS_PAGINA',
        'title',
        'h1pagina',
        'URL_PAGINA',
        'SI_UTIL',
        'NO_UTIL',
        'ESTADO_PAGINA'
    ];
}
