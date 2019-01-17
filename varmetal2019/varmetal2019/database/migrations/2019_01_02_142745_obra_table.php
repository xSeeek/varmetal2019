<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ObraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obra', function (Blueprint $table) {
            $table->increments('idObra');
            $table->string('codigo');
            $table->boolean('terminado')->default('false');
            $table->string('proyecto')->default('No determinada');
            $table->timestamp('fechaInicio')->now();
            $table->timestamp('fechaFin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obra');
    }
}
