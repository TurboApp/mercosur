<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManiobraTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maniobra_tareas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coordinacion_id');
            $table->string('titulo_corto');
            $table->string('titulo_largo')->nullable();
            $table->integer('avance')->default(0);
            $table->text('observaciones')->nullable();
            $table->dateTime('inicio')->nullable();
            $table->dateTime('final')->nullable();
            $table->string('icono',20)->nullable();
            $table->string('status',10)->nullable();
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
        Schema::dropIfExists('maniobra_tareas');
    }
}
