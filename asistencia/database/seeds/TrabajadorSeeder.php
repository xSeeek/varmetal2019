<?php

use Illuminate\Database\Seeder;

class TrabajadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
       DB::table('trabajador')->insert([
           'nombre' => 'Administrador',
           'rut' => '11.111.111-1',
           'cargo' => 'M1',
           'estado' => true,
           'users_id_user' => 1,
           'password' => bcrypt('abc123456'),
       ]);
     }
}
