<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineasTransportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineas_transportes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->length(90);
            $table->string('tipo')->length(15)->nullable();
            $table->string('email')->length(60)->nullable();
            $table->string('telefono')->length(20)->nullable();
            $table->string('celular')->length(20)->nullable();
            $table->string('direccion')->nullable();
            $table->string('rfc')->length(15)->nullable();
            $table->string('codigo_postal')->length(10)->nullable();
            $table->string('ciudad')->length(60)->nullable();
            $table->string('pais')->length(20)->nullable();
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
        Schema::dropIfExists('lineas_transportes');
    }
}
