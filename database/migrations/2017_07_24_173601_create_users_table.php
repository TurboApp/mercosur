<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',150);
            $table->string('email')->length(60)->unique();
            $table->string('direccion',160);
            $table->string('telefono',15);
            $table->integer('celular')->length(15)->unique();
            $table->string('url_avatar');
            $table->string('user',15);
            $table->string('password');
            $table->integer('id_perfil')->unsigned();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('id_perfil')->references('id')->on('perfiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
