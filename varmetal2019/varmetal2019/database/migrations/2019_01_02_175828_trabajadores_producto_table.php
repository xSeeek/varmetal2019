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
            $table->integer('trabajador_id_trabajador')->unsigned();
            $table->integer('conjunto_id_conjunto')->unsigned();
            $table->timestamp('fechaComienzo')->nullable();
            $table->float('kilosTrabajados')->default(0);
            $table->integer('productosRealizados')->default(0);
            $table->integer('pausasRealizadas')->default(0);
            $table->float('tiempoEnPausa')->nullable();
            $table->float('tiempoEnSetUp')->nullable();

            $table->foreign('trabajador_id_trabajador')->references('idTrabajador')->on('trabajador')->onDelete('cascade');
            $table->foreign('conjunto_id_conjunto')->references('idConjunto')->on('conjunto_producto')->onDelete('cascade');
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
