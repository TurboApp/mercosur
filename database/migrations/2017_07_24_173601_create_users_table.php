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
            $table->string('apellido',150);
            $table->string('email')->length(60)->unique()->nullable();
            $table->string('direccion',160);
            $table->string('telefono',20)->nullable();
            $table->string('celular')->length(20);
            $table->string('url_avatar')->nullable();
            $table->string('user',50)->unique();
            $table->string('password');
            $table->integer('perfil_id');
            $table->rememberToken();
            $table->timestamps();

            //$table->foreign('perfil_id')->references('id')->on('perfils')->onDelete('cascade');
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
