<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    //
    public function getbanners(){

    	$banners = Banners::where('estado','=',1)->get();

    	return $banners;

    }
}
