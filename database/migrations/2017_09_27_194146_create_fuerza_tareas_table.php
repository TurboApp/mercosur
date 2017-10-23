<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuerzaTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuerza_tareas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',50);
            $table->string('apellido',50);
            $table->string('direccion')->nullable();
            $table->string('telefono',50)->nullable();
            $table->string('celular',50)->nullable();
            $table->string('categoria',50);
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
        Schema::dropIfExists('fuerza_tareas');
    }
}
