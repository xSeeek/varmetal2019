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
          $table->string('cargo');
          $table->boolean('estado')->default('true');
          $table->integer('users_id_user')->unsigned();
          $table->foreign('users_id_user')->references('id')->on('users')->onDelete('cascade');
          $table->integer('obra_id_obra')->unsigned()->nullable();
          $table->foreign('obra_id_obra')->references('idObra')->on('obra');
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
      Schema::dropIfExists('trabajador');
  }
}
