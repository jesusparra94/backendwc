<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosHasPeriodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_has_periodos', function (Blueprint $table) {
            $table->id('id_prd_has_periodo');

            $table->unsignedBigInteger('producto_id');

            $table->foreign('producto_id')->references('id_producto')->on('productos');

            $table->unsignedBigInteger('periodo_id');

            $table->foreign('periodo_id')->references('id_periodo')->on('periodos');

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
        Schema::dropIfExists('productos_has_periodos');
    }
}
