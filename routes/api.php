<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\DominiosController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\PrecioDominiosController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\SistemaOperativoController;
use App\Http\Controllers\SubcategoriasController;
use App\Http\Controllers\CuponesController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\ContactoWebController;
use App\Http\Controllers\PeriodosController;
use App\Http\Controllers\PreguntasFrecuentesController;
use App\Http\Controllers\BannersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//cupones
Route::get('validarcupon/{cupon}',[CuponesController::class,'validarcupon']);

Route::get('getcategorias',[CategoriasController::class,'show']);
// regiones
Route::get('getregiones',[CategoriasController::class,'showregiones']);
// comunas

// informacion del productos
Route::get('getcomunas/{id}',[CategoriasController::class,'showcomunas']);
Route::get('getproductos/{id}',[ProductosController::class,'show']);
Route::get('getproductoscategoria/{id}',[ProductosController::class,'showcategoria']);
Route::get('getproductoscategoriaslug/{slug}',[ProductosController::class,'showcategoriaslug']);
Route::get('getperiodo/{id}',[ProductosController::class,'periodosproducto']);
Route::get('getperiodo/{id}/{id_periodo}',[ProductosController::class,'periodoproducto']);
Route::get('dominios/{dominio}/{extension}',[PrecioDominiosController::class,'dominios']);
Route::get('preciodominios',[PrecioDominiosController::class,'preciodominios']);
Route::get('getos/{tipo}',[SistemaOperativoController::class,'show']);
Route::get('getproductosbuscados/{nombre}',[ProductosController::class,'buscarproductos']);
Route::get('getproductosxslug/{slug}',[ProductosController::class,'showslug']);

//dominios
Route::post('getdominio',[DominiosController::class,'getdominio']);


// empresa
Route::post('crearempresa',[EmpresasController::class,'store']);
Route::get('empresa/{email}',[EmpresasController::class,'showone']);
Route::get('empresascliente/{email}',[EmpresasController::class,'showall']);
Route::get('empresa/xid/{id}',[EmpresasController::class,'showxid']);
Route::post('validarrut',[EmpresasController::class,'validarrut']);

// generar order de compra

Route::post('generarorder',[ServiciosController::class,'crearservicio']);

// generar codigo de acceso rapido
Route::post('/solicitudcodigo', [AuthController::class,'enviarcodigorapido']);

//Formulario de contacto
Route::post('/registrarconsulta', [ContactoWebController::class,'registrar']);

// servicios
Route::get('getserviciospendpago/{id}',[ServiciosController::class,'showpendpago']);
Route::get('getservicios/{id}/{subcategoria}',[ServiciosController::class,'show']);
Route::post('pagarventa',[ServiciosController::class,'pagarventa']);
Route::get('getconsultarservicios/{id_empresa}',[ServiciosController::class,'consultarServicios']);
// ventas

Route::get('getfacturaspendpago/{id}',[VentasController::class,'showpendpago']);

// login

Route::post('/login', [AuthController::class,'login']);
Route::post('/logincode', [AuthController::class,'logincode']);
Route::get('/solicitudcambiopass/{email}', [AuthController::class,'solicitudrecuperarpassword']);
Route::get('/getcodepassword/{code}', [AuthController::class,'getcodepassword']);
Route::post('/cambiopassword', [AuthController::class,'cambiopassword']);
Route::post('/loginadmin', [AuthController::class,'loginadmin']);

//Obtener IP
Route::get('/consultarip', [AuthController::class,'consultarip']);

//preguntas frecuentes
Route::get('/preguntasfrecuentesall', [PreguntasFrecuentesController::class,'showall']);
Route::get('/getfaq/{slug}', [PreguntasFrecuentesController::class,'getfaq']);
Route::get('/getpreguntasfrecuentesbuscadas/{nombre}',[PreguntasFrecuentesController::class,'buscarpreguntasfrecuentes']);

//banners
Route::get('/getbanners', [BannersController::class,'getbanners']);

Route::middleware('auth:sanctum')->group(function(){

    Route::get('/validartoken', [AuthController::class,'validartoken']);

});



// aqui las rutas del admin


Route::prefix('admin')->middleware('auth:sanctum')->group(function(){

    // periodos

    Route::get('getperiodos', [PeriodosController::class, 'show']);

    // categorias

    Route::get('getcategorias',[CategoriasController::class,'show']);
    Route::post('crearcategorias', [CategoriasController::class,'store']);
    Route::get('validarnombrecategoria/{nombre}', [CategoriasController::class,'validarnombrecategoria']);
    Route::delete('eliminarcategoria/{categoria}', [CategoriasController::class, 'destroy']);

    // productos

    Route::post('crearproducto',[ProductosController::class,'store']);
    Route::get('validarnombreproducto/{nombre}', [ProductosController::class,'validarnombreproducto']);
    Route::get('getproductos',[ProductosController::class,'showadmin']);
    Route::delete('eliminarproducto/{producto}', [ProductosController::class, 'destroy']);






});
