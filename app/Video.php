<?php

namespace App;

/**
 * Class Video
 *
 * A video which can be uploaded by a user.
 *
 * @package App
 */
class Video extends PhaseModel
{
    protected $guarded = [];
    protected $with = ['asset'];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopePublished($query)
    {
        return $query->where('published', 1);
    }

}
