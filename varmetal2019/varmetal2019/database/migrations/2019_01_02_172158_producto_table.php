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
            $table->string('nombre')->default('No Especificado');
            $table->string('codigo')->unique();
            $table->timestamp('fechaInicio')->timestamps();
            $table->timestamp('fechaFin')->nullable();
            $table->integer('pesoKg')->nullable();
            $table->integer('cantPausa')->default(0);
            $table->integer('cantProducto')->default(0);
            $table->integer('estado')->default('0');
            $table->integer('prioridad')->default('3');
            $table->boolean('terminado')->default('false');
            $table->timestamps();

            $table->integer('obras_id_obra')->unsigned()->nullable();
            $table->foreign('obras_id_obra')->references('idObra')->on('obra')->onDelete('cascade');
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
