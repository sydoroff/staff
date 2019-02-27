<?php

use Faker\Generator as Faker;

$factory->define(App\Staff::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'position' => $faker->jobTitle,
        'employment' => $faker->dateTimeBetween(),
        'pay' => $faker->numberBetween(1000,45000),
    ];
});
