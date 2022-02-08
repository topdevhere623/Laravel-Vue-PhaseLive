<?php

namespace App\Notifications;

use App\File;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TrackReported extends Notification
{
    use Queueable;

    public $track;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($track)
    {
        $this->track = $track;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            "title" => 'Track Reported!',
            "message" => $this->track->name.' reported',
            "image" => null
        ];
    }
}
