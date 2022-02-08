<?php

namespace App\Listeners;

use App\Events\UnFreezeAccount;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnFreezeUserContent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UnFreezeAccount  $event
     * @return void
     */
    public function handle(UnFreezeAccount $event)
    {
        $user = $event->user;

        $user->releases()->each(function ($release) {
            $release->unFreeze();
            $release->tracks()->each(function($track) {
                $track->unFreeze();
            });
        });

        Cache::forget('feed');
    }
}
