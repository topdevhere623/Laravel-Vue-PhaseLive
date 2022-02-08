<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence(15),
        'user_id' => 1,
        'commentable_id' => 1,
        'commentable_type' => 'news',
    ];
});
