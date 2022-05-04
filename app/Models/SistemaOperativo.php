<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemaOperativo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_os';

    public function versiones(){

        return $this->hasMany(VersionSistema::class,'os_id','id_os');
    }
}
