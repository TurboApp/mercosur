<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManiobraSubtareaAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maniobra_subtarea_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subtarea_id');
            $table->string('nombre');
            $table->string('url');
            $table->string('extension');
            $table->string('size');
            $table->string('minetype');
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
        Schema::dropIfExists('maniobra_subtarea_attachments');
    }
}
