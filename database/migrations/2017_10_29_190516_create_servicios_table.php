<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('agente_id');
            $table->integer('cliente_id');
            $table->integer('coordinacion_id')->nullable();
            $table->integer('servicio_padre')->nullable();
            $table->enum('tipo', ['Descarga','Carga','Trasbordo','Otros servicios']);
            $table->integer('numero_servicio');
            $table->date('fecha_recepcion');
            $table->time('hora_recepcion');
            $table->text('observaciones')->nullable();
            $table->string('destino');
            $table->string('destino_pais',60);
            
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
        Schema::dropIfExists('servicios');
    }
}
