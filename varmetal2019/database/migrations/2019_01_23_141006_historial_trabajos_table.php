<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HistorialTrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_trabajos', function (Blueprint $table) {
            $table->increments('idHistorial');
            $table->timestamp('fechaTrabajo')->now();
            $table->float('kilosRealizados')->default(0);
            $table->timestamps();

            $table->integer('ayudante_id_ayudante')->unsigned();
            $table->foreign('ayudante_id_ayudante')->references('idAyudante')->on('ayudantes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_trabajos');
    }
}
