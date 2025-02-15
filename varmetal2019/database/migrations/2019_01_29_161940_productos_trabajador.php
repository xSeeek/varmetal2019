<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductosTrabajador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_trabajador', function (Blueprint $table) {
            $table->integer('trabajador_id_trabajador')->unsigned();
            $table->integer('producto_id_producto')->unsigned();
            $table->timestamp('fechaComienzo')->nullable();
            $table->integer('productosRealizados')->default(0);
            $table->float('kilosTrabajados')->default(0);

            $table->foreign('trabajador_id_trabajador')->references('idTrabajador')->on('trabajador')->onDelete('cascade');
            $table->foreign('producto_id_producto')->references('idProducto')->on('producto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_trabajador');
    }
}
