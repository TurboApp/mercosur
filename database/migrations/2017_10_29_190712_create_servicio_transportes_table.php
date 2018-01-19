<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicioTransportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_transportes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('servicio_id');
            $table->integer('linea_transporte_id');
            $table->enum('operacion', ['Origen','Destino']);
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
            $table->string('numero_economico')->nullable();

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
        Schema::dropIfExists('servicio_transportes');
    }
}
