<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('event_image', function (Blueprint $table) {
        $table->bigIncrements('id')->index();
        $table->unsignedInteger('event_id')->index();
        $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
        $table->unsignedInteger('image_id')->index();
        $table->foreign('image_id')->references('id')->on('images')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('event_image');
    }
}
