<?php

namespace App;

use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * Class Report
 *
 * A user submitted report used to alert site admins to disallowed content
 *
 * @package App
 */
class Report extends PhaseModel
{
    use SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'reports.message' => 20,
            'users.name' => 20,
            'users.first_name' => 10,
            'users.last_name' => 10,
        ],
        'joins' => [
            'users' => ['users.id', 'reports.user_id']
        ]
    ];

    public function reportable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeAcknowledged($query)
    {
        return $query->where('acknowledged', true);
    }

    public function scopeUnAcknowledged($query)
    {
        return $query->where('acknowledged', false);
    }

    public function acknowledge($ak = true)
    {
        $this->acknowledged = $ak;
        $this->save();
        return $this;
    }
}
