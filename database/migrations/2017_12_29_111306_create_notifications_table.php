<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('emisor_id');
            $table->integer('receptor_id');
            $table->integer('servicio_id')->nullable();
            $table->string('titulo')->nullable();
            $table->text('mensaje')->nullable();
            $table->string('status')->default('no-read');
            $table->string('type')->default('info');
            $table->string('url_icon')->nullable();
            $table->string('url')->default('#');
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
        Schema::dropIfExists('notifications');
    }
}
