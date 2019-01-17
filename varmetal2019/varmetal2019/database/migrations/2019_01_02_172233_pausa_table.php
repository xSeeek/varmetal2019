<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PausaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('pausa', function (Blueprint $table) {
            $table->increments('idPausa');
            $table->string('descripcion')->nullable();
            $table->string('motivo')->nullable();
            $table->timestamp('fechaInicio')->timestamps();
            $table->timestamp('fechaFin')->nullable();
            $table->timestamps();

            $table->integer('producto_id_producto')->unsigned()->nullable();
            $table->foreign('producto_id_producto')->references('idProducto')->on('producto')->onDelete('cascade');

            $table->integer('trabajador_id_trabajador')->unsigned()->nullable();
            $table->foreign('trabajador_id_trabajador')->references('idTrabajador')->on('trabajador')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pausa');
    }
}
