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
            $table->string('descripcion');
            $table->date('fechaInicio')->timestamps();
            $table->date('fechaFin')->nullable();

            $table->integer('producto_id_producto')->unsigned();
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
        Schema::dropIfExists('pausa');
    }
}
