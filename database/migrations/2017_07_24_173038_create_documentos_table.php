<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('descarga_id')->unsigned();
            $table->integer('carga_id')->nullable()->unsigned();
            $table->string('tipo_documento',45);
            $table->string('documento',191);
            $table->longText('descripcion')->nullable();
            $table->enum('status',[0,1])->default(0);
            $table->dateTime('fecha_descarga');
            $table->dateTime('fecha_carga')->nullable();

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
        Schema::dropIfExists('documentos');
    }
}
