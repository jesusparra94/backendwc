<?php

namespace App\Http\Controllers;

use App\Models\Periodos;
use Illuminate\Http\Request;

class PeriodosController extends Controller
{
   public function show(){

        return Periodos::all();
   }
}
