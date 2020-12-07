<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('events', function (Blueprint $table) {
        $table->bigIncrements('id')->index();
        $table->string('title_fr')->unique();
        $table->string('title_en')->nullable();
        $table->string('creator');
        $table->integer('start_year');
        $table->integer('start_month')->nullable();
        $table->integer('start_day')->nullable();
        $table->integer('end_year')->nullable();
        $table->integer('end_month')->nullable();
        $table->integer('end_day')->nullable();
        $table->text('description_fr')->nullable();
        $table->text('description_en')->nullable();
        $table->text('bibliography_fr')->nullable();
        $table->text('bibliography_en')->nullable();
        $table->float('km_up',4,2)->nullable();
        $table->float('km_down',4,2)->nullable();
        $table->unsignedInteger('theme_id')->index();
        $table->foreign('theme_id')->references('id')->on('themes')->onDelete('cascade');
        $table->unsignedInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->multiPoint('points')->nullable()->spatialIndex();
        $table->multiLineString('lines')->nullable()->spatialIndex();
        $table->multiPolygon('polygons')->nullable()->spatialIndex();
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
      Schema::dropIfExists('events');
    }
}
