<?php

namespace App\Listeners;

use App\Events\BanUserAccount;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveUserContent
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
     * @param  BanUserAccount  $event
     * @return void
     */
    public function handle(BanUserAccount $event)
    {
        $user = $event->user;

        $user->releases()->each(function($release) {
            $release->delete();
            $release->tracks()->each(function($track) {
                $track->delete();
            });
        });

        Cache::forget('feed');
    }
}
