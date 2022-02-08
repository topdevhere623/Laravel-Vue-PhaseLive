<?php

namespace App\Listeners\ActionRegisters;

use App\Events\User\UpdatedAvatar;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;
use App\Action;

/**
 * Class RegisterAvatarUpdatedAction
 *
 * Register (save) the action in the database when a user updates their avatar
 *
 * @package App\Listeners\ActionRegisters
 */
class RegisterAvatarUpdatedAction
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
     * @param  UpdatedAvatar  $event
     * @return void
     */
    public function handle(UpdatedAvatar $event)
    {
        $action = new Action([
            'created_by' => Auth::user()->id,
            'public' => true,
            'item_type' => 'asset',
            'item_id' => $event->avatar_asset->id,
        ]);
        $action->event_type = $event;
        $action->save();
    }
}
