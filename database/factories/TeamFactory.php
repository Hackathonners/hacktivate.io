<?php

use App\Alexa\Models\Team;
use App\Alexa\Models\User;
use Faker\Generator as Faker;

$factory->define(Team::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text(200),
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
