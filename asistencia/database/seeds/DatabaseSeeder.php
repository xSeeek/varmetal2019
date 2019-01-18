<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call(UserSeeder::class);
    //$this->call(TrabajadorSeeder::class);

    DB::table('trabajador')->insert([
        'nombre' => 'Administrador',
        'rut' => '11.111.111-1',
        'cargo' => 'M1',
        'estado' => true,
        'users_id_user' => 1,
    ]);

    DB::table('trabajador')->insert([
        'nombre' => 'Xavier Esteban Díaz Espíndola',
        'rut' => '19.774.094-9',
        'cargo' => 'M3',
        'estado' => true,
        'users_id_user' => 2,
    ]);

    DB::table('trabajador')->insert([
        'nombre' => 'Francisco Andres Riquelme Cavagnola',
        'rut' => '19.619.104-6',
        'cargo' => 'M3',
        'estado' => true,
        'users_id_user' => 3,
    ]);

    DB::table('trabajador')->insert([
        'nombre' => 'Patricio Ignacio Torres Rojas',
        'rut' => '19.617.161-4',
        'cargo' => 'M3',
        'estado' => true,
        'users_id_user' => 4,
    ]);

    DB::table('trabajador')->insert([
        'nombre' => 'Supervisor Pruebas',
        'rut' => '11.111.113-8',
        'cargo' => 'M2',
        'estado' => true,
        'users_id_user' => 5,
    ]);

    DB::table('trabajador')->insert([
        'nombre' => 'Supervisor Pruebas 2',
        'rut' => '11.111.112-K',
        'cargo' => 'M2',
        'estado' => true,
        'users_id_user' => 6,
    ]);

    //factory(Asistencia\Trabajador::class, 100)->create();
  }
}
