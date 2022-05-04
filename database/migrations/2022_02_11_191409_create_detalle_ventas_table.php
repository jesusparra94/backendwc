<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id('id_detalle_ventas');
            $table->integer('cantidad');
            $table->integer('precio_mensual');
            $table->integer('precio_unitario');
            $table->integer('descuento');
            $table->integer('precio_descuento');
            $table->integer('precio_pagado');
            $table->unsignedBigInteger('venta_id');
            $table->foreign('venta_id')->references('id_venta')->on('ventas');
            $table->unsignedBigInteger('servicio_id');
            $table->foreign('servicio_id')->references('id_servicio')->on('servicios');

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
        Schema::dropIfExists('detalle_ventas');
    }
}
