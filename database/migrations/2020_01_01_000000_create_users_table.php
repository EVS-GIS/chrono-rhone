<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users', function (Blueprint $table) {
        $table->bigIncrements('id')->index();
        $table->string('firstname');
        $table->string('name');
        $table->string('organization');
        $table->string('email')->unique();
        $table->string('password');
        $table->unsignedInteger('role_id')->index();
        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        $table->rememberToken();
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
      Schema::dropIfExists('users');
    }
}
