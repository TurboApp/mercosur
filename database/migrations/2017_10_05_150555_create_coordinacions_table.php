<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordinacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinacions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('servicio_id')->unsigned();
            $table->integer('coordinador_id')->nullable()->unsigned();
            $table->integer('supervisor_id')->nullable()->unsigned();
            $table->integer('turno')->unsigned();
            $table->string('status')->default('Para Asignar');
            $table->date('fecha_servicio');
            $table->datetime('inicio_maniobra')->nullable();
            $table->datetime('termino_maniobra')->nullable();
            $table->smallInteger('avance_total')->default(0);
            $table->smallInteger('indice_activo')->default(0);
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
        Schema::dropIfExists('coordinacions');
    }
}
