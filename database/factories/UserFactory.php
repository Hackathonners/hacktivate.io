<?php

use App\Alexa\Models\Role;
use App\Alexa\Models\User;
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
    $userName = $faker->unique()->userName;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'avatar' => 'https://avatars3.githubusercontent.com/u/'.$faker->randomNumber,
        'github' => $faker->unique()->userName,
        'location' => $faker->city,
        'phone_number' => $faker->phoneNumber,
        'gender' => $faker->randomElement(['f', 'm', 'o']),
        'birthdate' => $faker->date,
        'dietary_restrictions' => $faker->text(50),
        'school' => $faker->numerify('University #'),
        'major' => $faker->words(4, true),
        'study_level' => $faker->randomElement(['undergraduate', 'msc', 'phd']),
        'special_needs' => $faker->words(10, true),
        'bio' => $faker->text(200),
        'remember_token' => str_random(10),
        'role_id' => function () {
            return Role::inRandomOrder()->first()->id;
        },
    ];
});

$factory->state(User::class, 'with-team', function (\Faker\Generator $faker) {
    return [
        'team_id' => function () {
            return factory(Team::class)->create()->id;
        },
    ];
});
