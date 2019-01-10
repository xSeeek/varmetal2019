<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Obra extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('obra', function (Blueprint $table) {
          $table->increments('idObra');
          $table->string('nombre');
          $table->integer('encargado_id_encargado')->unsigned();
          $table->foreign('encargado_id_encargado')->references('idTrabajador')->on('trabajador')->onDelete('cascade');
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
