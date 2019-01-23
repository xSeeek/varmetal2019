<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabajosAyudantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos_ayudantes', function (Blueprint $table) {
            $table->integer('ayudante_id_ayudante')->unsigned();
            $table->integer('historial_id_historial')->unsigned();

            $table->foreign('ayudante_id_ayudante')->references('idAyudante')->on('ayudantes')->onDelete('cascade');
            $table->foreign('historial_id_historial')->references('idHistorial')->on('historial_trabajos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajos_ayudantes');
    }
}
