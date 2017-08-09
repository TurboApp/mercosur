<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenServicioTransportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_servicio_transportes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_orden_servicio')->unsigned();
            $table->integer('id_linea_transporte')->unsigned();
            $table->timestamps();
            $table->foreign('id_orden_servicio')->references('id')->on('orden_servicios');
            $table->foreign('id_linea_transporte')->references('id')->on('lineas_transportes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_servicio_transportes');
    }
}
