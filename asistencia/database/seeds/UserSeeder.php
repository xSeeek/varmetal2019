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

      
    }
}
