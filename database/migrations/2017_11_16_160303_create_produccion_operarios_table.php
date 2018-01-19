<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduccionOperariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produccion_operarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coordinacion_id');
            $table->integer('fuerza_tarea_id');
            $table->dateTime('inicio')->nullable();
            $table->dateTime('final')->nullable();
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
        Schema::dropIfExists('produccion_operarios');
    }
}
