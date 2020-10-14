<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contato;
use App\Models\Usuario;
use Faker\Generator as Faker;

$factory->define(Contato::class, function (Faker $faker) {
    return [
        'id'=> $faker->unique()->randomNumber(),
        'nome' => $faker->name,
        'idUsuario'=> factory(Usuario::class)->create()->id
    ];
});
