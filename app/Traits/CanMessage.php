<?php

namespace App\Traits;

/**
 * Trait CanMessage
 *
 * Applied to classes that have the ability to send/receive messages
 *
 * @package App\Message
 */

trait CanMessage
{
    public function messages()
    {
        return $this->belongsToMany('App\Message', 'thread');
    }
}