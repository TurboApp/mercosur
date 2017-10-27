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
            $table->string('tipo',15);//Descarga,Carga,Trasbordo,Otros Servicios
            $table->integer('agente_id')->unsigned();
            $table->integer('cliente_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('numero_servicio');
            $table->date('fecha_recepcion');
            $table->time('hora_recepcion');
            $table->string('destino');
            $table->string('destino_pais',60)->nullable();
            $table->string('status',20);
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('orden_servicios');
    }
}
