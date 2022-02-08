<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 *
 * A single message sent from a single user to a thread.
 *
 * @package App
 */
class Message extends Model
{
    protected $fillable = ['body', 'sender_id', 'thread_id'];

    protected $touches = ['thread'];

    // protected $hidden = ['thread'];

    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }

    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id');
    }

    public function scopeReceivers($query)
    {
        $sender = $this->sender;

        return $this->thread
                    ->users
                    ->where('id', '!=', $sender->id);
    }
}
