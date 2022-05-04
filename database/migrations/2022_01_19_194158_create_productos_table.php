<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre');
            $table->string('slug');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_key');
            $table->integer('precio');
            $table->integer('visible')->nullable()->default(1);
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id_categoria')->on('categorias');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
