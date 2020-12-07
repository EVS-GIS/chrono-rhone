<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('events_relationships', function (Blueprint $table) {
        $table->bigIncrements('id')->index();
        $table->unsignedInteger('relationship_id')->index();
        $table->foreign('relationship_id')->references('id')->on('relationships')->onDelete('cascade');
        $table->unsignedInteger('from_event_id')->index();
        $table->foreign('from_event_id')->references('id')->on('events')->onDelete('cascade');
        $table->unsignedInteger('to_event_id')->index();
        $table->foreign('to_event_id')->references('id')->on('events')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('events_relationships');
    }
}
