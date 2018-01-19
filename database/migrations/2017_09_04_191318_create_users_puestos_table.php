<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersPuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puestos_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario');
            $table->integer('id_puesto');
            //$table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            //$table->foreign('id_puesto')->references('id')->on('puestos')->onDelete('cascade');
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
        Schema::dropIfExists('puestos_usuarios');
    }
}
