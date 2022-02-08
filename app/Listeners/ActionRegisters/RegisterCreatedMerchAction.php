<?php

namespace App\Listeners\ActionRegisters;

use App\Events\User\CreatedMerch;
use App\Action;

class RegisterCreatedMerchAction
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
     * @param  CreatedMerch  $event
     * @return void
     */
    public function handle(CreatedMerch $event)
    {
        $action = new Action([
            'created_by' => $event->merch->user->id,
            'public' => true,
            'item_type' => 'merch',
            'item_id' => $event->merch->id,
        ]);
        $action->event_type = $event;
        $action->save();
    }
}
