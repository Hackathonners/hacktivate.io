<?php

use App\Alexa\Models\User;
use App\Alexa\Models\Role;
use Faker\Generator as Faker;

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

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'github' => $faker->unique()->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role_id' => function () {
            return Role::inRandomOrder()->first()->id;
        },
    ];
});
