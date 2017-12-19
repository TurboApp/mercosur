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
            $table->string('nombre');
            $table->string('contacto')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('categoria',50);
            $table->enum('status',[0,1])->default(0);
            $table->integer('coordinacion_id')->nullable();
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
