<?php

namespace App;

/**
 * A user created playlist for tracks
 *
 * Class Playlist
 * @package App
 */
class Playlist extends PhaseModel
{
    protected $fillable = ['name', 'description'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tracks()
    {
        return $this->belongsToMany('App\Track');
    }

    public function scopeNameNotNull($query){
        return $query->where('name', '<>', '');
    }

}
