<?php

namespace App\Mail;

use App\User;
use App\Release;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessingRelease extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Release
     */
    public $release;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Release $release
     */
    public function __construct(User $user, Release $release)
    {
        $this->release = $release;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.releases.processing');
    }
}
