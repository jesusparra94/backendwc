<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarateristicasProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carateristicas_productos', function (Blueprint $table) {
            $table->id('id_carateristica_producto');
            $table->string('nombre');
            $table->string('capacidad')->nullable();
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id_producto')->on('productos');
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
        Schema::dropIfExists('carateristicas_productos');
    }
}
