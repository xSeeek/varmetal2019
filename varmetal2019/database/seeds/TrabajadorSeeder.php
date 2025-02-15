<?php

use Illuminate\Database\Seeder;

use Varmetal\Trabajador;
use Varmetal\User;

class TrabajadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = User::find(1);
      $trabajador = new Trabajador();
      $trabajador->nombre = 'Administrador';
      $trabajador->rut = '9.999.999-3';
      $trabajador->cargo = 'MK1';
      $trabajador->tipo = 'Administrador';
      $trabajador->estado = true;
      $user->trabajador()->save($trabajador);
    }
}
