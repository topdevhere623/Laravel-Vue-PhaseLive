<?php

namespace App\Mail;

use App\User;
use App\Release;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReleaseApproved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;
    /**
     * @var Release
     */
    public $release;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Release $release
     */
    public function __construct(User $user, Release $release)
    {
        $this->user = $user;
        $this->release = $release;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.releases.approved');
    }
}
