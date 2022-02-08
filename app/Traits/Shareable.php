<?php

namespace App\Traits;

use Auth;

/**
 * Trait Shareable
 *
 * Applied to classes that have the ability to be shared
 *
 * @package App\Traits
 */
trait Shareable
{
    public function shares()
    {
        return $this->morphMany('App\Share', 'shareable');
    }

    public function getShareCountAttribute()
    {
        return $this->shares()->count();
    }

    public function isShared($user = null)
    {
        $user = ($user ? $user : Auth::user());
        if(!$user) return;

        $share = $this->shares()->where('user_id', $user->id)->get();

        return $share->count() > 0;
    }

    public function getIsSharedAttribute()
    {
        return $this->isShared();
    }
}
