<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManiobraSubtareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maniobra_subtareas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tarea_id');
            $table->string('subtarea');
            $table->string('texto_ayuda')->nullable();
            $table->text('value')->nullable();
            $table->string('inputType',30)->nullable();
            $table->integer('limit')->length(2)->default(1);
            $table->string('options')->nullable();
            $table->integer('required')->length(1)->default(1);
            $table->enum('tipo_transporte',['N','C'])->nullable();
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
        Schema::dropIfExists('maniobra_subtareas');
    }
}
