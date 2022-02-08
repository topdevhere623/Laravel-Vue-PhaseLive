<?php

namespace App\Notifications;

use App\File;
use App\Http\Resources\MessageResource;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
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

        if ($notifiable->notification_setting['activity_message_email']) {
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
            "title" => 'New Message Received!',
            "message" => $this->message->sender->name.' sent you a message',
            "image" => env('AWS_URL').'/'.$this->message->sender->avatar->files['medium']['path'],
            "data" => [
                'id' => $this->message->id,
                'body' => $this->message->body,
                'sender' => $this->message->sender->id,
                'date' => $this->message->created_at
            ]
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Message Received')
            ->markdown('emails.notifications.message', [
                'user' => $notifiable,
                'message_user' => $this->message->sender->name
            ]);
    }
}
