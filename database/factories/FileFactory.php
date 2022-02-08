<?php

use Faker\Generator as Faker;

$factory->define(App\File::class, function (Faker $faker) {
    $now = now();

    return [
        'created_at' => $now,
        'updated_at' => $now,
        'size' => 'original',
        'path' => 'covers/example.png',
        'mime' => 'image/jpeg',
        'asset_id' => function () {
            return factory(App\Asset::class)->create()->id;
        }
    ];
});
