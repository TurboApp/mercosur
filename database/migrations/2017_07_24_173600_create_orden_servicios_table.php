<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo',35);
            $table->integer('id_agente')->unsigned();
            $table->integer('id_cliente')->unsigned();
            $table->integer('numero_servicio');
            $table->date('fecha_recepcion');
            $table->string('hora_recepcion',12);
            $table->string('observaciones');
            $table->integer('id_destino')->unsigned();
            $table->string('pais_destino',35);
            $table->string('estado',20);
            $table->timestamps();

            $table->foreign('id_agente')->references('id')->on('agentes');
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->foreign('id_destino')->references('id')->on('destinos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_servicios');
    }
}
