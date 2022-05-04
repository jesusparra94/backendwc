<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactoWebsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacto_webs', function (Blueprint $table) {
            
            $table->id('id_contacto_web');

            $table->string('nombre');

            $table->string('email');

            $table->string('telefono');

            $table->longText('mensaje');

            $table->text('ip');

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
        Schema::dropIfExists('contacto_webs');
    }
}
