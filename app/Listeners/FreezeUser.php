<?php

namespace App\Listeners;

use App\Events\FreezeAccount;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FreezeUser
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
        $event->user->freeze();
    }
}
