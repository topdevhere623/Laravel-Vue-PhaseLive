<?php

use Faker\Generator as Faker;

$factory->define(App\Track::class, function (Faker $faker) {
    $release = collect(App\Release::all())->random(1)->first();
    $user = collect(App\User::all())->random(1)->first();
    return [
      'name' => $faker->sentence(3),
      'length' => $faker->numberBetween(1, 10),
      'bpm' => $faker->numberBetween(60, 200),
      'key' => $faker->randomElement(),
      'price' => $faker->numberBetween(60, 200),
      'release_id' => $release->id,
      'uploaded_by' => $user->id,
      'preview_id' => 1,
    ];
});
