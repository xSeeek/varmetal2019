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

    //factory(Asistencia\Trabajador::class, 100)->create();
  }
}
