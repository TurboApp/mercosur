<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListasEmpaquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    // public function up()
    // {
    //     Schema::create('listas_empaques', function (Blueprint $table) {
    //         $table->increments('id');
    //         $table->integer('id_documento')->unsigned();
    //         $table->string('clave_articulo',20);
    //         $table->string('descripcion',160);
    //         $table->integer('cantidad_enviada');
    //         $table->string('unidad_medida',30);
    //         $table->float('peso_total',8,2);
    //         $table->timestamps();
    //         $table->foreign('id_documento')->references('id')->on('documentos');
    //     });
    // }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     Schema::dropIfExists('listas_empaques');
    // }
}
