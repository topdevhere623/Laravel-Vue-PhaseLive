<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountDetailsChanged extends Mailable
{
    use Queueable, SerializesModels;

    public string $type;
    public Authenticatable $user;

    /**
     * Create a new message instance.
     *
     * @param  string  $type
     */
    public function __construct($user, string $type)
    {
        $this->user = $user;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.account.details-changed');
    }
}
