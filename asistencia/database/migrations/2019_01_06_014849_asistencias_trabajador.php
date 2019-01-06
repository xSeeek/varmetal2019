<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AsistenciasTrabajador extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
      Schema::create('asistencias_trabajador', function (Blueprint $table) {
          $table->integer('trabajador_id_trabajador')->unsigned()->nullable();
          $table->integer('asistencia_id_asistencia')->unsigned()->nullable();
          $table->foreign('trabajador_id_trabajador')->references('idTrabajador')->on('trabajador');
          $table->foreign('asistencia_id_asistencia')->references('idAsistencia')->on('asistencia');
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
      Schema::dropIfExists('trabajadores_producto');
  }
}
