<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenServicioTransportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_servicio_transportes', function (Blueprint $table) {
            
            $table->increments('id');

            $table->integer('id_orden_servicio')->unsigned();
            $table->integer('id_linea_transporte')->unsigned();
            $table->string('nombre_operador',120);
            $table->string('tipo_unidad');
            $table->string('medida_unidad',30);
            $table->string('ejes',25);
            $table->smallInteger('cantidad');
            $table->string('talon_embarque');
            $table->string('marca_vehiculo');
            $table->string('placas_tractor');
            $table->string('placas_caja');
            $table->string('sellos')->nullable();
            $table->string('type');

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
        Schema::dropIfExists('orden_servicio_transportes');
    }
}
