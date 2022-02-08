<?php

use Faker\Generator as Faker;

use App\Thread;
use App\User;

$factory->define(App\Message::class, function (Faker $faker) {
    $thread = Thread::create();
    $user = User::first();
   
    return [
        'body' => $faker->paragraph,
        'thread_id' => $thread->id,
        'sender_id' => $user->id
    ];
});
