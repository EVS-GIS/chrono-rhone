<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('themes', function (Blueprint $table) {
        $table->bigIncrements('id')->index();
        $table->string('name_fr')->unique();
        $table->string('name_en');
        $table->integer('ranking');
        $table->string('color');
        $table->unsignedInteger('thematic_id')->index();
        $table->foreign('thematic_id')->references('id')->on('thematics');
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
      Schema::dropIfExists('themes');
    }
}
