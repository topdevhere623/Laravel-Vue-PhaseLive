<?php

namespace App;

/**
 * Class Like
 *
 * A like represents when a single user 'likes' a likeable object
 *
 * @package App
 */
class Like extends PhaseModel
{
    protected $fillable = ['user_id'];

    //protected $with = ['liker'];

    public function likeable()
    {
        return $this->morphTo();
    }

    public function liker()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    // public function user()
    // {
    //     return $this->hasOne('App\User', 'id', 'user_id');
    // }
}
