<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->integer('id_documento')->unsigned();
            $table->string('tipo_unidad',35);
            $table->string('medida_unidad',30);
            $table->string('ejes',25);
            $table->smallInteger('cantidad',2);
            $table->string('nombre_operador',120);
            $table->string('talon_embarque',25);
            $table->string('marca_vehiculo',25);
            $table->string('placas_tractor',12);
            $table->string('placas_caja',12);
            $table->string('sellos',10);
            $table->timestamps();
            $table->foreign('id_documento')->references('id')->on('documentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos');
    }
}
