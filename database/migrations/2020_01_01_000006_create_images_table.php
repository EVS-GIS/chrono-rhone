<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('images', function (Blueprint $table) {
        $table->bigIncrements('id')->index();
        $table->string('filename')->unique();
        $table->text('legend_fr')->nullable();
        $table->text('legend_en')->nullable();
        $table->string('copyright')->nullable();
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
      Schema::dropIfExists('images');
    }
}
