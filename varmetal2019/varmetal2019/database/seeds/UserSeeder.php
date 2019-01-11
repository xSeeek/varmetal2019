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
        DB::table('trabajador')->insert([
            'email' => 'elmacaco@gmail.com',
            'type' => 'Trabajador',
            'password' => bcrypt('Raideon133'),
        ]);
        //factory(Varmetal\User::class, 100)->create();
    }
}
