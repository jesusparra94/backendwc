<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosHasPeriodos extends Model
{
    use HasFactory;

    protected $primaryKey= 'id_prd_has_periodo';

   protected $fillable = [
        'producto_id',
        'periodo_id'
    ];

    public function periodo(){

        return $this->belongsTo(Periodos::class,'periodo_id');
    }
}
