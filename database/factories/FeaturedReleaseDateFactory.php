<?php

use Faker\Generator as Faker;

$factory->define(App\FeaturedReleaseDates::class, function (Faker $faker) {
    $release = collect(App\Release::all())->random(1)->first();

    return [
        'release_id' => $release->id,
        'featured_date' => now(),
    ];
});
