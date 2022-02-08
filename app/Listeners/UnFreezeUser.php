<?php

namespace App\Listeners;

use App\Events\UnFreezeAccount;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnFreezeUser
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
        $event->user->unFreeze();
    }
}
