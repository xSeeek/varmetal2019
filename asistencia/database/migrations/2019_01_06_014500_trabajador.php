<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Trabajador extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('trabajador', function (Blueprint $table) {
          $table->increments('idTrabajador');
          $table->string('nombre');
          $table->string('rut')->unique();
          $table->boolean('estado')->default('true');
          $table->timestamps();
          $table->integer('users_id_user')->unsigned();
          $table->foreign('users_id_user')->references('id')->on('users')->onDelete('cascade');
      });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      Schema::disableForeignKeyConstraints();
      Schema::dropIfExists('trabajador');
  }
}
