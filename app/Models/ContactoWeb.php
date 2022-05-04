<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactoWeb extends Model
{
    use HasFactory;
    protected $primaryKey =  "id_contacto_web";

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'mensaje',
        'ip'
    ];
}
