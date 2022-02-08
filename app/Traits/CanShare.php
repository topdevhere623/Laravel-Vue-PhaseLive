<?php

namespace App\Traits;

use App\Events\User\SharedItem;

use App\Share;

/**
 * Trait CanShare
 *
 * Applied to classes that have the ability to share items
 *
 * @package App\Traits
 */
trait CanShare
{
    public function share($shareable, $message)
    {
        $share = Share::create([
            'user_id' => $this->id,
            'shareable_id' => $shareable->id,
            'shareable_type' => $shareable->type,
            'message' => $message,
        ]);
        event(new SharedItem($share));
    }
}