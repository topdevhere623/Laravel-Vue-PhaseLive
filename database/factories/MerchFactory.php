<?php

use Faker\Generator as Faker;

$factory->define(App\Merch::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->paragraph(),
        'image_id' => rand(3, 31),
        'user_id' => 1,
    ];
});
