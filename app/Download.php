<?php

namespace App;

/**
 * Class Download
 *
 * A Download represents the ability for a user to download a Track at a specified quality but a limited number of times.
 *
 * @package App
 */
class Download extends PhaseModel
{
    protected $fillable = ['order_id', 'track_id'];

    protected $with = ['track'];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function track()
    {
        return $this->belongsTo('App\Track');
    }
}