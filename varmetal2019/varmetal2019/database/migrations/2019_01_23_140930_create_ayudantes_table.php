<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAyudantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ayudantes', function (Blueprint $table) {
            $table->increments('idAyudante');
            $table->string('nombre');
            $table->string('rut')->unique();
            $table->boolean('estado')->default('false');
            $table->string('tipo')->default('Operador');
            $table->timestamps();

            $table->integer('lider_id_trabajador')->unsigned()->nullable();
            $table->foreign('lider_id_trabajador')->references('idTrabajador')->on('trabajador')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ayudantes');
    }
}
