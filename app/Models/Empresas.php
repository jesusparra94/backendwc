<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;

   protected $primaryKey= 'id_empresa';

   protected $fillable = [
                'nombre',
                'tipo',
                'rut',
                'email',
                'telefono',
                'email_empresa',
                'telefono_empresa',
                'razonsocial',
                'giro',
                'direccion',
                'pais',
                'region',
                'comuna',
                'user_id'
            ];

}
