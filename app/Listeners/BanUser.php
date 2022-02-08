<?php

namespace App\Listeners;

use App\Events\BanUserAccount;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BanUser
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
        $event->user->banned_at = now();
        $event->user->save();
        $event->user->delete();
    }
}
