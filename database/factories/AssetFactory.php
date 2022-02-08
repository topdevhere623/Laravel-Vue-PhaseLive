<?php

use Faker\Generator as Faker;

$factory->define(App\Asset::class, function (Faker $faker) {
    $now = now();

    return [
        'created_at' => $now,
        'updated_at' => $now,
        'alt' => $faker->sentence(3),
    ];
});
