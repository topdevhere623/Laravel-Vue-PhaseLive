<?php

namespace App\Listeners\ActionRegisters;

use App\Events\User\CreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Action;

/**
 * Class RegisterCreatedEventAction
 *
 * Register (save) the action in the database when a user creates a new event
 *
 * @package App\Listeners\ActionRegisters
 */
class RegisterCreatedEventAction
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
     * @param  CreatedEvent  $event
     * @return void
     */
    public function handle(CreatedEvent $event)
    {
        $action = new Action([
            'created_by' => $event->event->user->id,
            'public' => true,
            'item_type' => 'event',
            'item_id' => $event->event->id,
        ]);
        $action->event_type = $event;
        $action->save();
    }
}
