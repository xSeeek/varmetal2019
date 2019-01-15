<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ObraSupervisor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('obra_supervisor', function (Blueprint $table) {
        $table->integer('trabajador_id_trabajador')->unsigned();
        $table->integer('obras_id_obra')->unsigned();
        $table->timestamp('tiempoPerdido')->nullable();
        $table->timestamp('tiempoSetUp')->nullable();

        $table->foreign('obras_id_obra')->references('idObra')->on('obra')->onDelete('cascade');
        $table->foreign('trabajador_id_trabajador')->references('idTrabajador')->on('trabajador')->onDelete('cascade');
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('obra_supervisor');
    }
}
