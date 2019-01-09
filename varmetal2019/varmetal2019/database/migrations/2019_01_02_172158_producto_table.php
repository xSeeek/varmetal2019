<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('idProducto');
            $table->string('nombre');
            $table->time('fechaInicio')->timestamps();
            $table->time('fechaFin')->nullable();
            $table->integer('pesoKg')->nullable();
            $table->integer('cantPausa')->default(0);
            $table->integer('cantProducto')->default(1);
            $table->integer('estado')->default('0');
            $table->integer('prioridad')->default('3');
            $table->timestamps();

            //$table->integer('pausa_id_pausa')->unsigned()->nullable();
            //$table->foreign('pausa_id_pausa')->references('idPausa')->on('pausa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto');
    }
}
