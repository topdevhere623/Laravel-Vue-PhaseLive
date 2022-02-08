<?php

namespace App\Traits;

use App\Events\User\FollowedUser;
use App\Notification;
use App\Notifications\UserFollowed;

/**
 * Trait Follow
 *
 * Applied to classes that have the ability to follow be followed
 *
 * @package App\Traits
 */
trait Follow
{
    public function followers()
    {
        return $this->belongsToMany('App\User', 'followers', 'target_id', 'follower_id')->withTimestamps();
    }

    public function following()
    {
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'target_id')->withTimestamps();
    }

    public function getFollowerCountAttribute()
    {
        return $this->followers->count();
    }

    /**
     * This object now follows the followable
     *
     * @param $followable
     * @return $this
     */
    public function follow($followable)
    {
        if(!$this->follows($followable) && $followable->id != $this->id) {
            $followable->followers()->save($this);
            event(new FollowedUser($this, $followable));
            Notification::notifyUser($followable, new UserFollowed($this));
        }
        return $this;
    }

    /**
     * This object no longer follows the followable
     *
     * @param $followable
     * @return $this
     */
    public function unfollow($followable)
    {
        $followable->followers()->detach($this);
        return $this;
    }

    /**
     * Check if this object follows the followable
     *
     * @param $followable
     * @return mixed
     */
    public function follows($followable)
    {
        if (is_null($followable)) {
            return false;
        }

        return $followable->followers->contains($this);
    }
}
