<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TrabajadoresProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajadores_producto', function (Blueprint $table) {
            $table->integer('trabajador_id_trabajador')->unsigned()->nullable();
            $table->integer('producto_id_producto')->unsigned()->nullable();
            $table->foreign('trabajador_id_trabajador')->references('idTrabajador')->on('trabajador');
            $table->foreign('producto_id_producto')->references('idProducto')->on('producto');
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
