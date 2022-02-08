<?php

namespace App\Traits;

use Auth;
use App\Like;
use App\Action;

use App\Events\User\LikedItem;

/**
 * Trait Likeable
 *
 * Applied to classes that have the ability to be liked
 *
 * @package App\Traits
 */
trait Likeable
{
    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function like($user = null)
    {
        $user = ($user ? $user : Auth::user());
        if(!$user) return;

        $like = $this->likes()->where('user_id', $user->id)->first();

        if (empty($like))
        {
            $like = new Like(['user_id' => $user->id]);
            $this->likes()->save($like);
            $like->refresh();
            event(new LikedItem($like));
        }
    }
    public function unlike($user = null)
    {
        $user = ($user ? $user : Auth::user());
        if(!$user) return;

        $action = Action::where('item_type', $this->type)
            ->where('item_id', $this->id)
            ->first();
        $action->delete();

        $like = $this->likes()->where('user_id', $user->id)->first();
        $like->delete();
    }

    public function isLiked($user = null)
    {
        $user = ($user ? $user : Auth::user());
        if(!$user) return;

        $like = $this->likes()->where('user_id', $user->id)->get();

        return $like->count() > 0;
    }

    public function getIsLikedAttribute()
    {
        return $this->isLiked();
    }

    public function getLikeCountAttribute()
    {
        return $this->likes->count();
    }
}
