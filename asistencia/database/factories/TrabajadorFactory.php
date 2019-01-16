<?php

use Faker\Generator as Faker;


$factory->define(Asistencia\Trabajador::class, function (Faker $faker) {
  $user = factory('Asistencia\User')->create();
  $user->save();
  return [
      'users_id_user' => $user->id,
      'rut' => function () {
        do {
          $number = rand($min = 3000000, $max = 15000000);
          $alumno = Asistencia\Trabajador::where('rut', Rut::set($number)->fix()->format())->first();
        } while ($alumno != null && $profesor != null);

        return Rut::set($number)->fix()->format();
      },
      'nombre' => $faker->firstName . ' ' . $faker->lastName,
      'cargo' => 'M1',
      'estado' => true,
    ];
});
