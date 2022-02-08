<?php

namespace App\Notifications;

use App\File;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPost extends Notification implements ShouldQueue
{
    use Queueable;

    public $post;
    public $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post, $type)
    {
        $this->post = $post;
        $this->type = $type;
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
        //if a user is posting on their own wall then notification is for followers as follow
        if ($this->type == 'self'){
            $message = $this->post->user->name.' added a new post';
        } else {
            //but if the user is posting on someone's else wall then the above will be triggered in addition
            //to notifying the profile owner as well
            $message = $this->post->user->name.' added a new post on your wall';
        }
        return [
            "title" => 'New Post!',
            "message" => $message,
            "image" => null
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("New Post")
            ->markdown('emails.notifications.new', [
                'type' => 'Post',
                'user' => $notifiable,
                'message_user' => $this->post->user->name
            ]);
    }
}
