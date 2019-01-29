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
            $table->float('pesoKg')->nullable();
            $table->integer('cantPausa')->default(0);
            $table->integer('cantProducto')->default(0);
            $table->integer('estado')->default('0');
            $table->integer('prioridad')->default('3');
            $table->boolean('terminado')->default('false');
            $table->float('tiempoEnPausa')->nullable();
            $table->float('tiempoEnSetUp')->nullable();
            $table->timestamps();

            $table->integer('obras_id_obra')->unsigned()->nullable();
            $table->foreign('obras_id_obra')->references('idObra')->on('obra')->onDelete('cascade');

            $table->integer('tipo_id_tipo')->unsigned()->default('1');
            $table->foreign('tipo_id_tipo')->references('idTipo')->on('tipo')->onDelete('cascade');

            $table->integer('conjunto_id_conjunto')->nullable();
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
        Schema::dropIfExists('producto');
    }
}
