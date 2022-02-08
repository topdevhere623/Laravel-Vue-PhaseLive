<?php

namespace App\Traits;

/**
 * Trait Commenter
 *
 * Applied to classes that have the ability to comment on commentables
 *
 * @package App\Traits
 */
trait Commenter
{
    public function comments()
    {
        return $this->hasMany('App\Comment', 'user_id');
    }
}