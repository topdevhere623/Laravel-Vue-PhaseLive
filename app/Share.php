<?php

namespace App;

/**
 * Class Share
 *
 * Represents a single user 'sharing' a single shareable
 *
 * @package App
 */
class Share extends PhaseModel
{
    protected $guarded = [];

    protected $with = ['shareable'];

    public function shareable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
