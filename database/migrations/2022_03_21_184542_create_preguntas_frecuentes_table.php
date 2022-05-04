<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntasFrecuentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas_frecuentes', function (Blueprint $table) {
            $table->id('ID_PAGINA');
            $table->string('TITULO_PAGINA');
            $table->string('SUBTITULO_PAGINA');
            $table->integer('ID_PAGINA_PERTENECE');
            $table->integer('ORDEN_PAGINA');
            $table->string('CONTENIDO_PAGINA');
            $table->string('SCRIPTS_PAGINA');
            $table->string('DESCRIPCION_PAGINA');
            $table->string('KEYWORDS_PAGINA');
            $table->string('title')->nullable();
            $table->string('h1pagina')->nullable();
            $table->string('URL_PAGINA');
            $table->integer('SI_UTIL');
            $table->integer('NO_UTIL');
            $table->integer('ESTADO_PAGINA');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preguntas_frecuentes');
    }
}
