<?php

use Illuminate\Database\Seeder;
use Varmetal\Material;

class MaterialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $material = new Material();
      $material->timestamps = false;
      $material->codigo = 'Gas';
      $material->nombre = 'Gas';
      $material->tipo = 'Soldador';
      $material->save();

      $material = new Material();
      $material->timestamps = false;
      $material->codigo = 'Alambre';
      $material->nombre = 'Alambre';
      $material->tipo = 'Soldador';
      $material->save();

      $material = new Material();
      $material->timestamps = false;
      $material->codigo = 'Pintura TE DIJIMOS HERMANO LA PULENTA';
      $material->nombre = 'Pintura';
      $material->tipo = 'Pintor';
      $material->save();

    }
}
