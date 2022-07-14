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

Route::get('/invoice', function () {
    return view('mails/acceso_cuenta');
});

Route::get('/cpanel', function () {
    return view('mails/acceso_cpanel');
});

Route::get('/servicios', function () {
    return view('mails/notificacion_servicios');
});

Route::get('enviarcorreo',[ServiciosController::class,'enviarcorreo']);

Route::get('getdolar',[ServiciosController::class,'getdolar']);

Route::get('plantilla',[ServiciosController::class,'verplantilla']);


Route::match(['get','post'],'/return/token',[ServiciosController::class,'validarrpago']);
Route::get('returnsuccess/paypal',[ServiciosController::class,'successTransaction']);
Route::get('returncancel/paypal',[ServiciosController::class,'cancelTransaction']);


Route::match(['get','post'],'/resultado/inscripcion',[ServiciosController::class,'validarinscripcion']);



