<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicioMercanciaDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_mercancia_documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('servicio_id');
            $table->integer('documento_padre')->nullable();
            $table->string('tipo_documento');
            $table->string('num_documento');
            $table->text('mercancia_descripcion')->nullable();
            $table->enum('status',['0','1'])->default('0');

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
        Schema::dropIfExists('servicio_mercancia_documentos');
    }
}
