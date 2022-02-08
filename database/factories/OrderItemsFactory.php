<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\OrderItem;
use Faker\Generator as Faker;

$item_types = ['release', 'track'];

$factory->define(OrderItem::class, function (Faker $faker) use($item_types) {
    return [
        'order_id' => $faker->numberBetween(1,12),
        'item_id' => 1,
        'item_type' => $faker->randomElement($item_types),
        'price' => 299,
        'seller_id' => $faker->numberBetween(1,4),
        'created_at' => $faker->dateTimeBetween('-1 years', now()),
        'updated_at' => $faker->dateTimeBetween('-1 years', now())
    ];
});
