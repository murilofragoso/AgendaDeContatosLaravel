<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Usuario;
use Faker\Generator as Faker;

$factory->define(Usuario::class, function (Faker $faker) {
    return [
        'id'=> $faker->randomNumber(),
        'nome' => $faker->name,
        'email' => $faker->unique()->email,
        'senha' => $faker->password()
    ];
});
