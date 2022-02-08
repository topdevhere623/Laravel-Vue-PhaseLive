<?php

namespace App\Listeners;

use App\Events\FreezeAccount;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FreezeUserContent
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
     * @param  FreezeAccount  $event
     * @return void
     */
    public function handle(FreezeAccount $event)
    {
        $user = $event->user;

        $user->releases()->each(function ($release) {
            $release->freeze();
            $release->tracks()->each(function($track) {
                $track->freeze();
            });
        });

        Cache::forget('feed');
    }
}
