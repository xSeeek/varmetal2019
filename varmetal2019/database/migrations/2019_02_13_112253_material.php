<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Material extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('material', function (Blueprint $table) {
          $table->increments('idMaterial');
          $table->string('codigo')->unique();
          $table->string('nombre');
          $table->string('tipo')->default('Material');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('material');

    }
}
