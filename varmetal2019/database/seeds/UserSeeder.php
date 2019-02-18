<?php

use Illuminate\Database\Seeder;
use Varmetal\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = new User();
      $user->email = 'admin@localhost.com';
      $user->type = User::ADMIN_TYPE;
      $user->password = bcrypt('abc123456');
      $user->save();


    }
}
