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
          'email' => 'diazxavier27@gmail.com',
          'type' => 'Trabajador',
          'password' => bcrypt('abc123456'),
      ]);

      DB::table('users')->insert([
          'email' => 'francisco.riquelme@outlock.com',
          'type' => 'Trabajador',
          'password' => bcrypt('abc123456'),
      ]);

      DB::table('users')->insert([
          'email' => 'patricio.igtr@gmail.com',
          'type' => 'Trabajador',
          'password' => bcrypt('abc123456'),
      ]);

      DB::table('users')->insert([
          'email' => 'supervisor@gmail.com',
          'type' => 'Supervisor',
          'password' => bcrypt('abc123456'),
      ]);

      DB::table('users')->insert([
          'email' => 'supervisor2@gmail.com',
          'type' => 'Supervisor',
          'password' => bcrypt('abc123456'),
      ]);

    }
}
