<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id('id_banner');

            $table->longText('banner');

            $table->longText('banner_movil');

            $table->string('link');

            $table->string('title');

            $table->string('alt');

            $table->integer('estado');

            $table->string('titulo');

            $table->longText('texto');

            $table->integer('posicion');

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
        Schema::dropIfExists('banners');
    }
}
