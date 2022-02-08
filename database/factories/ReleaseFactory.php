<?php

use Faker\Generator as Faker;

$classes = [
    'album',
    'single',
    'ep',
    'sample',
    'compilation'
];

$statuses = [
    'pending',
    'live',
    'offline'
];

$factory->define(App\Release::class, function (Faker $faker) use ($classes, $statuses) {
    $created = Carbon\Carbon::createFromTimestamp($faker->unixTime())->toDateTimeString();
    $user = collect(App\User::all())->random(1)->first();

    return [
        'name' => $faker->sentence(3),
        'description' => $faker->paragraph(),
        'status' => $statuses[array_rand($statuses)],
        'class' => $classes[array_rand($classes)],
        'price' => rand(100, 2000),
        'featured' => rand(0, 1),
        'image_id' => rand(8, 32),
        'uploaded_by' => $user->id,
        'release_date' => \Carbon\Carbon::createFromTimestamp($faker->unixTime()),
        'deleted_at' => null,
        'created_at' => $faker->dateTimeBetween('-2 weeks', now()),
        'updated_at' => $created,
    ];
});
