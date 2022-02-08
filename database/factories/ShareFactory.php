<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Release;
use App\Share;
use Faker\Generator as Faker;

$factory->define(Share::class, function (Faker $faker) {

    $release_ids = Release::all()->map(function($r){
        return $r->id;
    });

    return [
        'created_at' => now(),
        'updated_at' => now(),
        'user_id' => $faker->numberBetween(1, 4),
        'shareable_type' => 'release',
        'shareable_id' => $release_ids->random()
    ];
});
