<?php

namespace App\Listeners;

use App\Events\User\EmailChanged;
use App\Mail\AccountDetailsChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EmailChangedListener
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
     * @param  EmailChanged  $event
     * @return void
     */
    public function handle(EmailChanged $event)
    {
        Mail::to($event->user->email)->send(new AccountDetailsChanged($event->user, 'email'));
    }
}
