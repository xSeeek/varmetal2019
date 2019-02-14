<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MaterialesGastados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('materiales_gastados', function (Blueprint $table) {
          $table->integer('trabajador_id_trabajador')->unsigned();
          $table->integer('material_id_material')->unsigned();
          $table->integer('producto_id_producto')->unsigned();
          $table->float("gastado")->default(0);
          $table->timestamp('fechaTermino')->nullable();

          $table->foreign('trabajador_id_trabajador')->references('idTrabajador')->on('trabajador')->onDelete('cascade');
          $table->foreign('material_id_material')->references('idMaterial')->on('material')->onDelete('cascade');
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
      Schema::dropIfExists('materiales_gastados');
    }
}
