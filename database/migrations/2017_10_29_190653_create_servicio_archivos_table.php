<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicioArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_archivos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('servicio_id');
            $table->string('nombre');
            $table->string('url');
            $table->string('extension');
            $table->string('minetype');
            $table->string('size');
            
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
        Schema::dropIfExists('servicio_archivos');
    }
}
