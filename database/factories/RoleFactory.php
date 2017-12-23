<?php

use Faker\Generator as Faker;
use App\Alexa\Models\Role as Role;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Role::class, function (Faker $faker) {
    $types = ['admin', 'user'];

    return [
        'type' => $types[array_rand($types, 1)],
    ];
});

$factory->state(Role::class, 'admin', function (Faker $faker) {
    return [
        'type' => 'admin',
    ];
});

$factory->state(Role::class, 'user', function (Faker $faker) {
    return [
        'type' => 'user',
    ];
});
