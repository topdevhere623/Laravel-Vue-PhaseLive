<?php

namespace App\Listeners\ActionRegisters;

use App\Events\User\SharedItem;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;
use App\Action;

/**
 * Class RegisterSharedItemAction
 *
 * Register (save) the action in the database when a user shares a shareable item
 *
 * @package App\Listeners\ActionRegisters
 */
class RegisterSharedItemAction
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
     * @param  SharedItem  $event
     * @return void
     */
    public function handle(SharedItem $event)
    {
        $action = new Action([
            'created_by' => Auth::user()->id,
            'public' => true,
            'item_type' => 'share',
            'item_id' => $event->share->id,
        ]);
        $action->event_type = $event;
        $action->save();
    }
}
