<?php

namespace App\Listeners\ActionRegisters;

use App\Events\User\PlacedOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Action;

/**
 * Class RegisterPlacedOrderAction
 *
 * Register (save) the action in the database when a user places an order
 *
 * @package App\Listeners\ActionRegisters
 */
class RegisterPlacedOrderAction
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
     * @param  PlacedOrder  $event
     * @return void
     */
    public function handle(PlacedOrder $event)
    {
        $action = new Action([
            'created_by' => $event->order->purchaser->id,
            'public' => false,
            'item_type' => 'order',
            'item_id' => $event->order->id,
        ]);
        $action->event_type = $event;
        $action->save();
    }
}
