<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuponesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cupones', function (Blueprint $table) {
            $table->id('id_cupon');

            $table->string('cupon');

            $table->integer('valor');

            $table->date('fecha_vec');

            $table->unsignedBigInteger('tipo_descuento_id');

            $table->foreign('tipo_descuento_id')->references('id_tipo_descuento')->on('tipo_descuentos');

            $table->unsignedBigInteger('estado_id');

            $table->foreign('estado_id')->references('id_estado')->on('estados');

            $table->unsignedBigInteger('servicio_id')->nullable();

            $table->foreign('servicio_id')->references('id_servicio')->on('servicios');

            
            /*
            $table->unsignedBigInteger('subcategoria_id');

            $table->foreign('subcategoria_id')->references('id_subcategoria')->on('subcategorias');

            */

            $table->integer('uso_max');

            $table->integer('uso_actual');
            
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
        Schema::dropIfExists('cupones');
    }
}
