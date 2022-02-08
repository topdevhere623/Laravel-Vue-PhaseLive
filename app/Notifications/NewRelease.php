<?php

namespace App\Notifications;

use App\File;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRelease extends Notification implements ShouldQueue
{
    use Queueable;

    public $release;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($release)
    {
        $this->release = $release;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $vias = ['database', 'broadcast'];

        if ($notifiable->notification_setting->activity_post_from_followee_email) {
            $vias = array_merge(['mail'], $vias);
        }

        return $vias;
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
            "title" => $this->release->name,
            "message" => 'New Album added by '.$this->release->uploader->name,
            "image" => env('AWS_URL').$this->release->image->path
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("New Release")
            ->markdown('emails.notifications.new', [
                'type' => 'Release',
                'user' => $notifiable->name,
                'message_user' => $this->release->uploader->name
            ]);
    }
}
