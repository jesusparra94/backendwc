<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuponesHasSubcategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cupones_has_subcategorias', function (Blueprint $table) {

            $table->id('id_cupon_has_subcategoria');

            $table->unsignedBigInteger('subcategoria_id');

            $table->foreign('subcategoria_id')->references('id_subcategoria')->on('subcategorias');

            $table->unsignedBigInteger('cupon_id');

            $table->foreign('cupon_id')->references('id_cupon')->on('cupones');
            
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
        Schema::dropIfExists('cupones_has_subcategorias');
    }
}
