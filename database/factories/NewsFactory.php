<?php

use Faker\Generator as Faker;

$factory->define(App\News::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(6),
        'content' => $faker->paragraph,
        'path' => $faker->slug,
        'image_id' => rand(3, 31),
        'user_id' => 1,
        'published_at' => $faker->dateTimeBetween('-2 weeks', now()),
    ];
});
