<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_documento',45);
            $table->integer('id_orden_servicio_transporte')->unsigned();
            $table->string('num_documento',11);
            $table->string('descripcion_mercancia',120);
            $table->float('peso_bruto',8,2);
            $table->timestamps();
            $table->foreign('id_orden_servicio_transporte')->references('id')->on('orden_servicio_transportes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
