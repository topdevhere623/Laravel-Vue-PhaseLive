<?php

namespace App\Traits;

/**
 * Trait Liker
 *
 * Applied to classes that have the ability to like likeables
 *
 * @package App\Traits
 */
trait Liker
{
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}