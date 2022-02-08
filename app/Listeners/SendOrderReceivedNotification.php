<?php

namespace App\Listeners;

use App\Events\User\PlacedOrder;
use App\Mail\UserOrderReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;

use App\Setting;

/**
 * Class SendOrderReceivedNotification
 *
 * Send an email to the site admin when a user places an order
 *
 * @package App\Listeners
 */
class SendOrderReceivedNotification
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
        Mail::to(Setting::byKey('admin_email')->value)
            ->send(new UserOrderReceived($event->order));
    }
}
