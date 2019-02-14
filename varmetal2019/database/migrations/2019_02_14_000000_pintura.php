<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pintura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('pintura', function (Blueprint $table) {
          $table->increments('idPintura')->unsigned();

          $table->float('areaPintada')->unsigned()->default(0);
          $table->float('litrosGastados')->unsigned()->default(0);
          $table->float('espesor')->default(0);
          $table->integer('piezasPintadas')->default(0);
          $table->timestamp('dia')->default(now());
          $table->boolean('revisado')->default('false');
          $table->timestamps();

          $table->integer('producto_id_producto')->unsigned();
          $table->foreign('producto_id_producto')->references('idProducto')->on('producto')->onDelete('cascade');

          $table->integer('pintor_id_trabajador')->unsigned();
          $table->foreign('pintor_id_trabajador')->references('idTrabajador')->on('trabajador')->onDelete('set null');

          $table->integer('supervisor')->unsigned()->nullable();
          $table->foreign('supervisor')->references('idTrabajador')->on('trabajador')->onDelete('set null');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('pintura');
    }
}
