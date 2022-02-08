<?php

namespace App\Listeners;

use App\Events\User\PlacedOrder;
use App\Mail\UserOrderReceipt;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;

/**
 * Class SendOrderReceiptNotification
 *
 * Send a receipt to a user when they have placed an order
 *
 * @package App\Listeners
 */
class SendOrderReceiptNotification
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
        Mail::to($event->order->purchaser)
            ->send(new UserOrderReceipt($event->order));
    }
}
