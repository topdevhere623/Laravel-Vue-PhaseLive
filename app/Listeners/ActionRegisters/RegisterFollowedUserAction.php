<?php

namespace App\Listeners\ActionRegisters;

use App\Events\User\FollowedUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Action;

/**
 * Class RegisterFollowedUserAction
 *
 * Register (save) the action in the database when a user follows another user
 *
 * @package App\Listeners\ActionRegisters
 */
class RegisterFollowedUserAction
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
     * @param  FollowedUser  $event
     * @return void
     */
    public function handle(FollowedUser $event)
    {
        $action = new Action([
            'created_by' => $event->follower->id,
            'public' => true,
            'item_type' => 'user',
            'item_id' => $event->followed->id,
        ]);
        $action->event_type = $event;
        $action->save();
    }
}
