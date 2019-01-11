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
          'nombre' => 'brasucamacaco',
          'rut' => '19.617.161-4',
          'cargo' => 'M1',
          'estado' => 'true',
          'users_id_user' => '2',
        ]);
        //factory(Varmetal\User::class, 100)->create();
    }
}
