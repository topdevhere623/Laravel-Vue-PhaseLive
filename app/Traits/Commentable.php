<?php

namespace App\Traits;

use Illuminate\Http\Request;

use App\Comment;

use Auth;

/**
 * Trait Commentable
 *
 * Applied to classes that have the ability to be commented on
 *
 * @package App\Traits
 */
trait Commentable
{
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function getCommentCountAttribute()
    {
        return $this->comments->count();
    }

    public function addComment(Request $request, $user = null)
    {
        $user = ($user ? $user : Auth::user());
        if(!$user) return;

        $input = $request->all();

        $comment = new Comment([
            'body' => $input['body'],
            'user_id' => $user->id,
        ]);

        $this->comments()->save($comment);

        return $comment;
    }
}
