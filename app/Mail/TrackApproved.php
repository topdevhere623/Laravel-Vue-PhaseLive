<?php

namespace App\Mail;

use App\User;
use App\Track;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrackApproved extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    public $user;
    /**
     * @var Track
     */
    public $track;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Track $track
     */
    public function __construct(User $user, Track $track)
    {
        $this->user = $user;
        $this->track = $track;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.track.approved');
    }
}
