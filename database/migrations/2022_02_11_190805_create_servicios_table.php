<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id('id_servicio');
            $table->integer('codigo_venta');
            $table->string('glosa');
            $table->integer('cantidad');
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id_producto')->on('productos');
            $table->unsignedBigInteger('periodo_id');
            $table->foreign('periodo_id')->references('id_periodo')->on('periodos');
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id_categoria')->on('categorias');
            $table->string('dominio')->nullable();
            $table->dateTime('fecha_inscripcion');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_renovacion')->nullable();
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id_empresa')->on('empresas');
            $table->unsignedBigInteger('estado_id')->default(1);
            $table->foreign('estado_id')->references('id_estado')->on('estados');
            $table->integer('estado_creado')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
