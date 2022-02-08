<?php

namespace App\Listeners\ActionRegisters;

use App\Events\User\LikedItem;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Action;

/**
 * Class RegisterLikedItemAction
 *
 * Register (save) the action in the database when a user likes a likeable item
 *
 * @package App\Listeners\ActionRegisters
 */
class RegisterLikedItemAction
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
     * @param  LikedItem  $event
     * @return void
     */
    public function handle(LikedItem $event)
    {
        $action = new Action([
            'created_by' => $event->like->liker->id,
            'public' => true,
            'item_type' => $event->like->likeable_type,
            'item_id' => $event->like->likeable_id,
        ]);
        $action->event_type = $event;
        $action->save();
    }
}
