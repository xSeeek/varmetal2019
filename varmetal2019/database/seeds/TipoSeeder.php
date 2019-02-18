<?php

use Illuminate\Database\Seeder;
use Varmetal\Tipo;

class TipoSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $tipo = new Tipo();
    $tipo->nombreTipo = 'Mediana';
    $tipo->factorKilo = 0.75;
    $tipo->save();

    $tipo = new Tipo();
    $tipo->nombreTipo = 'Pesada';
    $tipo->factorKilo = 0.3;
    $tipo->save();

    $tipo = new Tipo();
    $tipo->nombreTipo = 'Ligera';
    $tipo->factorKilo = 0.8;
    $tipo->save();

    $tipo = new Tipo();
    $tipo->nombreTipo = 'Carpinteria';
    $tipo->factorKilo = 1;
    $tipo->save();

    $tipo = new Tipo();
    $tipo->nombreTipo = 'Preparación de Material';
    $tipo->factorKilo = 0.2;
    $tipo->save();
  }
}
