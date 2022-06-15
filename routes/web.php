<?php

use App\Http\Controllers\ServiciosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get','post'],'/return/token',[ServiciosController::class,'validarrpago']);
Route::get('returnsuccess/paypal',[ServiciosController::class,'successTransaction']);
Route::get('returncancel/paypal',[ServiciosController::class,'cancelTransaction']);


Route::match(['get','post'],'/resultado/inscripcion',[ServiciosController::class,'validarinscripcion']);

// flow

Route::match(['get', 'post'],'/pagos/retorno', [ServiciosController::class,'returns']);
Route::match(['get', 'post'],'/pagos/confirmacion', [ServiciosController::class,'confirmacion']);

