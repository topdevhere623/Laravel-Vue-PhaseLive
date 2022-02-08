<?php

namespace App;

use App\PhaseModel;
use App\Traits\Likeable;
use App\Traits\Reportable;
use Auth;

/**
 * Class Thread
 *
 * Represents a conversation between (currently) two users. Messages can be posted to this thread
 *
 * @package App
 */
class Thread extends PhaseModel
{
    use Likeable;
    use Reportable;
    protected $fillable = ['sender_id', 'receiver_id'];

    // protected $with = ['sender', 'receiver'];

    // protected $hidden = ['sender_id', 'receiver_id'];

    protected $appends = ['last_message'];

    public function messages()
    {
        return $this->hasMany('App\Message');
    }
    
    // public function sender()
    // {
    //     return $this->belongsTo('App\User');
    // }

    // public function receiver()
    // {
    //     return $this->belongsTo('App\User');
    // }

    public function users()
    {
        return $this->belongsToMany('App\User', 'thread_users')->withPivot(['read_at'])->withTimestamps();
    }

    public function getLastMessageAttribute()
    {
        return $this->messages->last();
    }

    public function getFirstMessageAttribute()
    {
        return $this->messages->first();
    }

    public function scopeByUserId($query, $id = null)
    {
        if (is_null($id))
            $id = Auth::id();

        return $query->where('sender_id', $id)->orWhere('receiver_id', $id);
    }

    public static function threadExistOrNew($senderId,$receiverId)
    {
        //get sender threads and loop through them
        foreach (User::find($senderId)->threads as $thread) {
            //check if there is a thread that's between the sender and receiver
                if($thread->users->contains(User::find($receiverId))){
                    //if yes return this thread
                    return $thread;
                }
        }

        //if no then return a new thread
        $thread = new Thread;
        $thread->save(); 
        $selectedThread = $thread;

        //Attach both users to the newly created thread
        User::find($senderId)->threads()->attach([
           $thread->id,
        ]);

        User::find($receiverId)->threads()->attach([
            $thread->id,
        ]);
        return $thread;
    }
}
