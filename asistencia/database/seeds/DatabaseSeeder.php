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
      DB::table('users')->insert([
          'email' => 'admin@localhost.com',
          'type' => 'Admin',
          'password' => bcrypt('abc123456'),
      ]);
  }
}
