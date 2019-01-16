<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
          'email' => 'admin@localhost.com',
          'type' => 'Admin',
          'password' => bcrypt('abc123456'),
      ]);

      DB::table('users')->insert([
          'email' => 'xubylele@gmail.com',
          'type' => 'Supervisor',
          'password' => bcrypt('abc123456'),
      ]);

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
          'cargo' => 'M2',
          'estado' => true,
          'users_id_user' => 2,
      ]);
    }
}
